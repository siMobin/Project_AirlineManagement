<?php
/* /////////////////////////////////////////////////////////////////////////////////////
    // Rename FPDF => PDF too
    // See full documentation here ==> http://www.fpdf.org/en/script/script2.php
*/ /////////////////////////////////////////////////////////////////////////////////////

class PDF extends FPDF
{
    var $angle = 0; // Initialize the rotation angle to 0 degrees

    // Function to rotate * shit
    function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q'); // Reset the current transformation matrix if an angle was previously set

        $this->angle = $angle; // Set the new rotation angle

        if ($angle != 0) {
            $angle *= M_PI / 180; // Convert the angle from degrees to radians
            $c = cos($angle);
            $s = sin($angle);

            $cx = $x * $this->k; // Calculate the x-coordinate for the center of rotation
            $cy = ($this->h - $y) * $this->k; // Calculate the y-coordinate for the center of rotation

            // Apply the rotation transformation to the page
            $this->_out(
                sprintf(
                    'q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',
                    $c,
                    $s,
                    -$s,
                    $c,
                    $cx,
                    $cy,
                    -$cx,
                    -$cy
                )
            );
        }
    }

    // Function to end the current page and reset the rotation angle
    function _endpage()
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q'); // Reset the transformation matrix and end the page
        }
        parent::_endpage(); // Call the parent class's endpage method
    }
}
