function photoImage($url, $width = 400, $height = 0)
{
        $url = 'https://i0.wp.com/' . str_replace(array('http://', 'https://'), '', $url);

        if($width && $height)
        {
                $url .= '?resize=' . $width . ',' . $height;
        }
        else
        {
                if($width) $url .= '?w=' . $width;
                if($height) $url .= '?h=' . $height;
        }

        return $url;
}
