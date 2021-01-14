<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Device.php';

class DeviceRepository extends Repository
{
    public function getDeviceList(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
            SELECT d.id, d.name, d.ip_address, l.name as location, os.description, os.color, d.status
            FROM devices d
                LEFT JOIN locations l ON d.id_location = l.id 
                LEFT JOIN operation_status os ON d.id_operation_status = os.id;
        ');
        $stmt->execute();

        $devices = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($devices as $device)
        {
            $result[] = new Device(
                $device['id'],
                $device['name'],
                '',
                $device['ip_address'],
                $device['location'],
                $device['description'],
                $device['color'],
                $device['status']
            );
        }

        return $result;
    }

    public function addDevice(Device $device, array $permissions)
    {
        $name = $device->getName();
        $ip_address = $device->getIpAddress();
        $comment = $device->getComment();
        $id_location = intval($device->getLocation());

        $stmt = $this->database->connect()->prepare('
            CALL add_device(:name, :ip_address, :comment, :id_location, :permissions);
        ');

        $id_user = '{';
        foreach ($permissions as $id)
        {
            $id_user = $id_user.$id;
            $id_user = next($permissions) ? $id_user.',' : $id_user.'}';
        }

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':ip_address', $ip_address);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':id_location', $id_location, PDO::PARAM_INT);
        $stmt->bindParam(':permissions', $id_user);
        $stmt->execute();
    }

    public function getDeviceById(int $id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT d.id, d.name, d.ip_address, l.name as location, os.description, os.color, d.status
            FROM devices d
                LEFT JOIN locations l ON d.id_location = l.id 
                LEFT JOIN operation_status os ON d.id_operation_status = os.id
            WHERE d.id = :id;
        ');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $device = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Device(
            $device['id'],
            $device['name'],
            '',
            $device['ip_address'],
            $device['location'],
            $device['description'],
            $device['color'],
            $device['status']
        );
    }

    public function getUserDevices(User $user): array
    {
        if ($user->getRole() == "administrator")
        {
            return $this->getDeviceList();
        }

        $result = [];
        $id = $user->getIdDatabase();

        $stmt = $this->database->connect()->prepare('
            SELECT d.id, d.name, d.ip_address, l.name as location, os.description, os.color, d.status
            FROM devices d
                 LEFT JOIN locations l ON d.id_location = l.id
                 LEFT JOIN operation_status os ON d.id_operation_status = os.id
                 LEFT JOIN user_device ud on d.id = ud.id_device
            WHERE ud.id_user = :id;
        ');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $devices = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($devices as $device)
        {
            $result[] = new Device(
                $device['id'],
                $device['name'],
                '',
                $device['ip_address'],
                $device['location'],
                $device['description'],
                $device['color'],
                $device['status']
            );
        }

        return $result;
    }

    public function getPermissionIdUsers(int $id_device): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
            SELECT id_user FROM user_device WHERE id_device = :id;
        ');
        $stmt->bindParam(':id', $id_device);
        $stmt->execute();
        $permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($permissions as $permission)
        {
            $result[] = new ArrayObject(["id_user" => $permission['id_user']]);
        }

        return $result;
    }

    public function revokePermission(int $id_user, int $id_device)
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM user_device WHERE id_user = :id_user AND id_device = :id_device;
        ');
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_device', $id_device);
        $stmt->execute();
    }

    public function getOnlineStats(): int
    {
        $stmt = $this->database->connect()->prepare('
            SELECT COUNT(id) as online FROM devices WHERE status = true;
        ');
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['online'];
    }
}