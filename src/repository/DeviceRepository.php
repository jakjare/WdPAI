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
}