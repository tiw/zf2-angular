<?php
namespace Tiddr\Image;

use WideImage\WideImage;
/**
 * Description of SmartResizer
 * resize the image
 *
 * @author wangting
 */
class SmartResizer
{

    /**
     * resize the image to a proper to width and height.
     * If the original image is 比例和输入的width和height不同的时候
     * 需要先裁剪在缩放
     *
     * @param string orignal image name    $imageName
     * @param string resized image name    $resizedName
     * @param int the pixel of the width   $wantedWidth
     * @param int the pixel of the height  $wantedHeight
     */
    public static function resize($imageDir, $imageName, $resizedImageName, $wantedWidth, $wantedHeight)
    {
        $image = WideImage::load($imageDir . '/' . $imageName);
        $width = $image->getWidth();
        $height = $image->getHeight();
        $b = $width / $height;
        if ($b < 1.5) {
// hoch format
            $factor = $wantedWidth / $width;
        } else {
            $factor = $wantedHeight / $height;
        }
        return $image->resize($factor * $width, $factor * $height)
                ->crop('center', 'center', $wantedWidth, $wantedHeight)
                ->saveToFile($imageDir . '/' . $resizedImageName);
    }

    public static function scale($imageDir, $imageName, $resizedImageName, $factor)
    {
        $image = WideImage::load($imageDir . '/' . $imageName);
        $width = $factor * $image->getWidth();
        $height = $factor * $image->getHeight();
        return $image->resize($width, $height)->saveToFile($imageDir . '/' . $resizedImageName);
    }

}

?>
