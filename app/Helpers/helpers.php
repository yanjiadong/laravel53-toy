<?php
if(!function_exists('alert'))
{
    function alert($params, $status)
    {
        if($status)
        {
            if (is_array($params))
            {
                $params['success'] = 1;
                $data = $params;
            }
            elseif ($params)
            {
                $data = array('success' => 1, 'url' => $params);
            }
            else
            {
                $data = array('success' => 1);
            }
        }
        else
        {
            if(is_array($params))
            {
                $data = array('success' => 0);
            }
            else
            {
                $data = array('success' => 0, 'message' => $params);
            }
        }

        return response()->json($data);
    }
}