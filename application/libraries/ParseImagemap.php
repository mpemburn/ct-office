<?php

class CI_ParseImagemap extends CI_DataManager
{
    var $prefix = null;
    var $document = null;

    public function __construct()
    {
        $this->config->load('ct_office');
        $this->prefix = $this->config->item('prefix');
    }

    //*** Magic method __get gives us access to the parent CI object
    public function __get($var)
    {
        static $CI;
        (is_object($CI)) OR $CI = get_instance();
        return $CI->$var;
    }

    public function parse_request($request)
    {
        //echo var_dump($request);
        if (sizeof($request) == 0) {
            $request = $_REQUEST;
        }
        $this->request = $request;
        switch ($this->get_request('type')) {
            case "GET_layout" :
                $this->document = $this->get_request('document');
                $data = $this->read_map($this->document);

                $optional_fields = $this->config->item($this->prefix . "." . $this->document . '.optional.fields');
                $this->echo_output(json_encode(array('status' => "SUCCESS", 'data' => $data, 'optional' => $optional_fields)));
                break;
        }
    }

    public function echo_output($data)
    {
        echo $data;
    }

    public function read_map($document_name, $output_type = "percent")
    {
        $map = $this->config->item($this->prefix . "." . $document_name . '.map');
        //echo var_dump($map);

        $out_values = [];
        // Create a new DOMDocument and load the image map into it
        $dom = new DOMDocument();
        $dom->loadHTML($map);
        // Read the img element to get the height and width
        $img = $dom->getElementsByTagName('img')->item(0);
        $image_height = $img->getAttribute('height');
        $image_width = $img->getAttribute('width');

        $areas = $dom->getElementsByTagName('area');
        for ($i = 0; $i < $areas->length; $i++) {
            $parsed = [];
            $area = $areas->item($i);
            // Get the field name from the href
            $field_name = $area->getAttribute('href');
            // Pull the coordinates out
            $coords = $area->getAttribute('coords');
            // Re-write coords and percent if specified
            if ($output_type == 'percent') {
                $parsed['coords'] = $this->get_coords_as_percent($coords, $image_width, $image_height);
            }
            if ($output_type == 'integer') {
                $parsed['coords'] = $this->get_coords($coords);
            }
            $parsed['field_name'] = $field_name;
            // The 'target' holds information on the type of field to display (input, select, textarea)
            $parsed['field_type'] = $area->getAttribute('target');
            // The action can contains a JSON object that gives further instructions to the Javascript code
            $parsed['action'] = $area->getAttribute('alt');
            $parsed['label_text'] = str_replace("_", " ", ucwords($parsed['field_name']));
            if (!empty($parsed)) {
                $out_values[$field_name] = $parsed;
            }
        }

        return $out_values;
    }

    private function get_coords_as_percent($coords, $image_width, $image_height)
    {
        $out_coords = array();
        $coords = $this->get_coords($coords);
        foreach ($coords as $key => $value) {
            //*** Create a value named for the coordinate
            switch ($key) {
                case "x" :
                    $value = $value / $image_width;
                    break;
                case "y" :
                    $value = $value / $image_height;
                    break;
                case "width" :
                    $value = $value / $image_width;
                    break;
                case "height" :
                    $value = $value / $image_height;
                    break;
            }
            $value = $this->fnumber_format(($value * 100), 2, ".", "") . "%";
            $out_coords[$key] = $value;
            //echo $key . " - " . $value . "\n";
        }
        return $out_coords;
    }

    private function get_coords($coords)
    {
        $coord_array = array_combine(['x', 'y', 'width', 'height'], explode(',', $coords));
        $coord_array['width'] -= $coord_array['x'];
        $coord_array['height'] -= $coord_array['y'];
        return $coord_array;
    }

    private function get_value($in_string, $attribute)
    {
        //*** Match for alpha-numeric, brackets, comma, colon and single quote to accomodate a JSON expression
        $m = preg_match("/$attribute\=[0-9a-zA-Z_\\[\\]{}:,'.%]+/", $in_string, $matches);
        if ($m) {
            $field = str_replace("$attribute=", "", $matches[0]);
            return $field;
        }
        return NULL;
    }

    private function fnumber_format($number, $decimals = '', $sep1 = '', $sep2 = '')
    {

        if (($number * pow(10, $decimals + 1) % 10) == 5)  //if next not significant digit is 5
        {
            $number -= pow(10, -($decimals + 1));
        }

        return number_format($number, $decimals, $sep1, $sep2);

    }
}

//*** END OF FILE ParseImagemap.php