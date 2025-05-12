<?php
final class App_Conditions_Forecast_Search_Result_Item
{
    /**
     * @var int|null
     */
    private ?int $year;

    /**
     * @var string|null
     */
    private ?string $seaArea;

    /**
     * @var string|null
     */
    private ?string $category;

    /**
     * @var string|null
     */
    private ?string $title;

    /**
     * @var string|null
     */
    private ?string $document;

    /**
     * @var DateTime|null
     */
    private ?DateTime $date;

    /**
     * @param int|null $year
     * @param string|null $seaArea
     * @param string|null $category
     * @param string|null $title
     * @param string|null $document
     * @param DateTime|null $date
     */
    public function __construct(
        ?int $year,
        ?string $seaArea,
        ?string $category,
        ?string $title,
        ?string $document,
        ?DateTime $date
    )
    {
        $this->year = $year;
        $this->seaArea = $seaArea;
        $this->category = $category;
        $this->title = $title;
        $this->document = $document;
        $this->date = $date;
    }

    /**
     * @param array $item
     * @return self
     * @throws Exception
     */
    public static function createFromCsv(array $item): self
    {
        return new self(
            intval($item[0] ?? null),
            $item[1] ?? null,
            $item[2] ?? null,
            $item[3] ?? null,
            $item[4] ?? null,
            $item[5] ? new DateTime($item[5], new DateTimeZone('Asia/Tokyo')) : null
        );
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @return string|null
     */
    public function getSeaArea(): ?string
    {
        return $this->seaArea;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getDocument(): ?string
    {
        return $this->document;
    }

    /**
     * @return DateTime|null
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getDocumentUrl(): ?string
    {
        if ($this->document) {
            return wp_get_attachment_url($this->document) ?: null;
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getDocumentSize(): ?int
    {
        if ($this->document) {
            return $this->getAttachmentFileSize($this->document);
        }

        return null;
    }

    /**
     * @param int $id
     * @return int|null
     */
    private function getAttachmentFileSize(int $id): ?int
    {
        $meta = wp_get_attachment_metadata($id);
        return $meta['filesize'] ?? null;
    }
}