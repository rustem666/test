<?php

/**
 * Class Data
 */
class Data
{
    /**
     *  directory of source files
     */
    const SOURCE_DIR = '/source/';

    /**
     *  constants for file types
     */
    const TYPE_FILE_PHP = 'php';
    const TYPE_FILE_XML = 'xml';
    const TYPE_FILE_JSON = 'json';

    /**
     * variable for result data
     * @var array
     */
    private $data = array();

    /**
     * get data from all files
     * @return array
     */
    public function getData()
    {
        if(!empty($_GET['source']))
        {
            $dir = self::getDocumentRoot() . self::SOURCE_DIR;
            if(is_dir($dir))
            {
                if($dh = opendir($dir))
                {
                    while(($file = readdir($dh)) !== false) {

                        if($file == '.' || $file == '..')
                        {
                            continue;
                        }

                        $extension = end(explode('.',$file));
                        if($extension == $_GET['source'])
                        {
                            switch($extension)
                            {
                                case self::TYPE_FILE_PHP:
                                    $this->data = self::getDataFromPHP($dir . $file);
                                    break;
                                case self::TYPE_FILE_XML:
                                    $this->data = self::getDataFromXML($dir . $file);
                                    break;
                                case self::TYPE_FILE_JSON:
                                    $this->data = self::getDataFromJSON($dir . $file);
                                    break;
                            }
                        }

                    }
                    closedir($dh);
                }
            }
            $this->filterData();
        }

        return $this->data;
    }


    /**
     * get data from php file
     * @param $path
     * @return array
     */
    protected static function getDataFromPHP($path)
    {
        $fileData = include_once $path;

        $data = array();

        foreach($fileData as $groupName => $groupData)
        {
            foreach($groupData as $currencyCode => $currencyData)
            {
                $data[] = array(
                    'code'      =>  $currencyCode,
                    'name'      =>  $currencyData['name'],
                    'value'     =>  $currencyData['value'],
                    'group'     =>  $groupName,
                );
            }
        }

        return $data;
    }

    /**
     * get data from xml file
     * @param $path
     * @return array
     */
    protected static function getDataFromXML($path)
    {
        $fileData = simplexml_load_file($path);

        $data = array();

        foreach($fileData as $item)
        {
            $data[] = array(
                'code'      =>  (string) $item->Code,
                'name'      =>  (string) $item->Description,
                'value'     =>  (string) $item->Value,
                'group'     =>  (string) $item['Type'],
            );
        }

        return $data;
    }

    /**
     * get data from json file
     * @param $path
     * @return array
     */
    protected static function getDataFromJSON($path)
    {
        $fileContent = file_get_contents($path);
        $fileData = json_decode($fileContent);

        $data = array();

        foreach($fileData as $item)
        {
            $data[] = array(
                'code'      =>  $item[0],
                'name'      =>  $item[1],
                'value'     =>  str_replace(',' , '.', $item[2]),
                'group'     =>  $item[3],
            );
        }

        return $data;
    }

    /**
     * get server document root
     * @return string
     */
    protected static function getDocumentRoot()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     *  filtering data using GET parameters
     */
    private function filterData()
    {
        if(!empty($_GET['group']))
        {
            $this->data = array_filter($this->data, function($item){
                if($item['group'] == $_GET['group'])
                {
                    return true;
                }
                return false;
            });
        }

        if(!empty($_GET['filter_field']) && !empty($_GET['filter_type']) && !empty($_GET['filter_value']))
        {
            $this->data = array_filter($this->data, function($item){
                if(isset($item[$_GET['filter_field']]))
                {
                    if($_GET['filter_type'] == '>')
                    {
                        if(preg_match('/^' . $_GET['filter_value'] . '/i', $item[$_GET['filter_field']]))
                        {
                            return true;
                        }
                    }
                    elseif($_GET['filter_type'] == '<')
                    {
                        if(preg_match('/' . $_GET['filter_value'] . '$/i', $item[$_GET['filter_field']]))
                        {
                            return true;
                        }
                    }
                    elseif($_GET['filter_type'] == 'ilike')
                    {
                        if(preg_match('/' . $_GET['filter_value'] . '/i', $item[$_GET['filter_field']]))
                        {
                            return true;
                        }
                    }
                }
                return false;
            });
        }

        if(!empty($_GET['sort']))
        {
            usort($this->data , function($a, $b){
                if($a[$_GET['sort']] == $b[$_GET['sort']])
                {
                    return 0;
                }
                if($_GET['order'] == 'asc')
                {
                    return ($a[$_GET['sort']] > $b[$_GET['sort']]) ? 1 : -1;
                }
                else
                {
                    return ($a[$_GET['sort']] < $b[$_GET['sort']]) ? 1 : -1;
                }
            });
        }
    }
}
