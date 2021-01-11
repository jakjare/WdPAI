<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Location.php';

class LocationRepository extends Repository
{
    public function getLocations(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM locations;
        ');
        $stmt->execute();

        $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($locations as $location)
        {
            $result[] = new Location(
                $location['id'],
                $location['name']
            );
        }

        return $result;
    }

    public function addLocation(Location $location): void
    {
        $name = $location->getName();
        $stmt = $this->database->connect()->prepare('
            INSERT INTO locations VALUES (default, LOWER(:name));
        ');
        $stmt->bindParam(':name', $name);
        $stmt->execute();
    }
}