<?php
final class App_Csv_Reader
{
    /**
     * @var string
     */
    private string $path;

    /**
     * @var string|null
     */
    private ?string $inputEncode;

    /**
     * @var string|null
     */
    private ?string $outputEncode;

    /**
     * @var
     */
    private $filePointer;

    /**
     * @param string $path
     * @param string|null $inputEncode
     * @param string|null $outputEncode
     */
    public function __construct(string $path, string $inputEncode = null, string $outputEncode = null)
    {
        $this->path = $path;
        $this->inputEncode = $inputEncode;
        $this->outputEncode = $outputEncode;
        $this->openFile();
    }

    /**
     * @param string $path
     * @param string $inputEncode
     * @return self
     */
    public static function create(string $path, string $inputEncode): self
    {
        return new self($path, $inputEncode, 'UTF-8');
    }

    /**
     * @return void
     */
    private function openFile(): void
    {
        if (!$fp = fopen($this->path, 'r'))
            wp_die(sprintf('CSVファイルの読み込みに失敗しました：%s', $this->path));

        $this->filePointer = $fp;
        $this->applyEncodeFilter();
    }

    /**
     * @return void
     */
    private function closeFile(): void
    {
        fclose($this->filePointer);
    }

    /**
     * @return void
     */
    private function applyEncodeFilter(): void
    {
        if (is_null($this->inputEncode) || is_null($this->outputEncode))
            return;

        if ($this->inputEncode === $this->outputEncode)
            return;

        stream_filter_append($this->filePointer, 'convert.iconv.' . $this->inputEncode . '/' . $this->outputEncode . '//TRANSLIT', STREAM_FILTER_READ);
    }

    /**
     * @return Generator
     */
    public function readLine(): Generator
    {
        while (!feof($this->filePointer)) {
            yield fgetcsv($this->filePointer);
        }

        $this->closeFile();
    }
}