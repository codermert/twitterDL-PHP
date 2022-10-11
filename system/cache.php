<?php
class Cache {
    function read($fileName) {
        $fileName = 'cache/' . $fileName;
        if (file_exists($fileName)) {
            $handle   = fopen($fileName, 'rb');
            $variable = fread($handle, filesize($fileName));
            fclose($handle);
            return unserialize($variable);
        } else {
            return null;
        }
    }
    function write($fileName, $variable) {
        $fileName = 'cache/' . $fileName;
        $handle   = fopen($fileName, 'a');
        fwrite($handle, serialize($variable));
        fclose($handle);
    }
    function delete($fileName) {
        $fileName = 'cache/' . $fileName;
        unlink($fileName);
    }
}
?>