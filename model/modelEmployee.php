<?php
class ModelEmployee
{
    private $jsonFile = "";
    public function __construct($jsonFile = './../data/employee.json')
    {
        $this->jsonFile = $jsonFile;
        $this->createIfnotExists($this->jsonFile);
    }

    private function createIfnotExists($filePath)
    {
        // Check if the file exists
        if (!file_exists($filePath)) {
            // Create an empty file
            $fileHandle = fopen($filePath, 'w'); // 'w' mode opens the file for writing
            if ($fileHandle) {
                fclose($fileHandle); // Close the file handle immediately
            }
        }
    }

    public function getRows()
    {
        if (file_exists($this->jsonFile)) {
            $jsonData = file_get_contents($this->jsonFile);
            $data = json_decode($jsonData, true);

            if (!empty($data)) {
                usort($data, function ($a, $b) {
                    return $b['id'] - $a['id'];
                });
            }

            return !empty($data) ? $data : false;
        }
        return false;
    }

    public function getSingle($id)
    {
        $jsonData = file_get_contents($this->jsonFile);
        $data = json_decode($jsonData, true);
        $singleData = array_filter($data, function ($var) use ($id) {
            return (!empty($var['id']) && $var['id'] == $id);
        });
        $singleData = !empty($singleData) ? array_values($singleData)[0] : null;
        return !empty($singleData) ? $singleData : false;
    }

    public function insert($newData)
    {
        if (!empty($newData)) {
            $id = time();
            $newData['id'] = $id;

            $jsonData = file_get_contents($this->jsonFile);
            $data = json_decode($jsonData, true);

            $data = !empty($data) ? array_filter($data) : $data;
            if (!empty($data)) {
                array_push($data, $newData);
            } else {
                $data[] = $newData;
            }
            $insert = file_put_contents($this->jsonFile, json_encode($data));

            return $insert ? $id : false;
        } else {
            return false;
        }
    }

    public function update($upData, $id)
    {
        if (!$this->getSingle($id)) {
            return false;
        }
        if (!empty($upData) && is_array($upData) && !empty($id)) {
            $jsonData = file_get_contents($this->jsonFile);
            $data = json_decode($jsonData, true);

            foreach ($data as $key => $value) {
                if ($value['id'] == $id) {

                    if (isset($upData['name'])) {
                        $data[$key]['name'] = $upData['name'];
                    }
                    if (isset($upData['email'])) {
                        $data[$key]['email'] = $upData['email'];
                    }
                    if (isset($upData['phone'])) {
                        $data[$key]['phone'] = $upData['phone'];
                    }
                    if (isset($upData['dob'])) {
                        $data[$key]['dob'] = $upData['dob'];
                    }
                    if (isset($upData['ic'])) {
                        $data[$key]['ic'] = $upData['ic'];
                    }
                    if (isset($upData['gender'])) {
                        $data[$key]['gender'] = $upData['gender'];
                    }
                    if (isset($upData['maritalStatus'])) {
                        $data[$key]['maritalStatus'] = $upData['maritalStatus'];
                    }
                    if (isset($upData['race'])) {
                        $data[$key]['race'] = $upData['race'];
                    }
                    if (isset($upData['nationality'])) {
                        $data[$key]['nationality'] = $upData['nationality'];
                    }
                    if (isset($upData['dateHire'])) {
                        $data[$key]['dateHire'] = $upData['dateHire'];
                    }
                    if (isset($upData['department'])) {
                        $data[$key]['department'] = $upData['department'];
                    }
                    if (isset($upData['address'])) {
                        $data[$key]['address'] = $upData['address'];
                    }
                }
            }
            $update = file_put_contents($this->jsonFile, json_encode($data));

            return $update ? true : false;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $jsonData = file_get_contents($this->jsonFile);
        $data = json_decode($jsonData, true);

        $newData = array_filter($data, function ($var) use ($id) {
            return ($var['id'] != $id);
        });
        $delete = file_put_contents($this->jsonFile, json_encode($newData));
        return $delete ? true : false;
    }
}