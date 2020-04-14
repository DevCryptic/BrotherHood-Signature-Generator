<?php

class SigGenerator_Properties
{
    protected $bgImage     = 'sig_bg.png';
    protected $fontFile    = 'modernno.20.ttf';
    protected $fontSize    = 30;

    protected $topBound    = 55;
}

class SigGenerator extends SigGenerator_Properties
{
    /**
     * Display name we're going to toss in the signature.
     * 
     * @access private
     * @var string
     */
    private $name = null;

    /**
     * Image handler.
     * 
     * @access private
     * @var resource
     */
    private $img = null;

    /**
     * Bounding box information used to centering text.
     * 
     * @access private
     * @var array
     */
    private $fBox = null;

    /**
     * Color identifier
     * 
     * @access private
     * @var int
     */
    private $col = null;


    /**
     *  Constructor: prepare image resource.
     * 
     * @access public
     */
    public function __construct ()
    {
        $this->prepareSignature();
    }

    /**
     * Destructor: clean up
     * 
     * @access public
     */
    public function __destruct()
    {
        imagedestroy($this->img);
    }

    /**
     * Set the name property.
     * 
     * @access public
     * @param string $name Name to be placed on signature
     * @throws Exception Bad name given.
     */
    public function setName($name)
    {
        $name = trim($name);

        if (!$name || empty($name)) {
            throw new Exception("Name must not be left blank.");
        }

        $this->name = $name;
        $this->prepareFont();
    }

    /**
     * Set color resource.
     * 
     * @param int $red Red value (0-255)
     * @param int $green Green value (0-255)
     * @param int $blue Blue value (0-255)
     * @throws Exception Bad parameters fed
     * @return int Color identified
     * @return bool Failure
     */
    public function setColor($red, $green, $blue)
    {
        if (!$red || !$green || !$blue) {
            throw new Exception("Must define full RGB values for color to be allocated.");
        }

        return $this->col = imagecolorallocate($this->img, $red, $green, $blue);
    }

    /**
     * Calculate center for text and output PNG image.
     * 
     * @access public
     * @return bool TRUE on success, FALSE otherwise
     */
    public function outputImage()
    {
        $fH = abs($this->fBox[5] - $this->fBox[3]);         // Font height
        $tA = imagesy($this->img) - $this->topBound;        // Text area top bounds
        $tD = imagesy($this->img) - $tA;                    // Text area height

        $x = ceil(imagesx($this->img) / 2 - $this->fBox[2] / 2);
        $y = $tA + ($tD - $fH / 2);

        imagettftext($this->img, $this->fontSize, 0, $x, $y, $this->col, $this->fontFile, $this->name);

        return imagepng($this->img);
    }

    /**
     * Set up the image handler.
     * 
     * @throws Exception No file found for background image.
     * @throws Exception Unable to create the resource.
     */
    private function prepareSignature()
    {
        if (!file_exists($this->bgImage)) {
            throw new Exception("Background image not found.");
        }

        $this->img = imagecreatefrompng($this->bgImage);

        if (!$this->img) {
            throw new Exception("Unable to create the background image.");
        }
    }

    /**
     * Set up the font boxing information.
     * 
     * @throws Exception No font file found.
     */
    private function prepareFont()
    {
        if (!file_exists($this->fontFile)) {
            throw new Exception("Font file not found.");
        }

        $this->fBox = imagettfbbox($this->fontSize, 0, $this->fontFile, $this->name);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty ($_GET['name'])) {
    $sig = new SigGenerator();
    $sig->setName(htmlspecialchars($_GET['name']));
    $sig->setColor(255, 255, 255);
    header('Content-type: image/png');
    readfile($sig->outputImage());
}