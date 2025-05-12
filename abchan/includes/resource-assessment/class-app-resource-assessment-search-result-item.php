<?php
final class App_Resource_Assessment_Search_Result_Item
{
    /**
     * @var string|null
     */
    private ?string $type;

    /**
     * @var int|null
     */
    private ?int $year;

    /**
     * @var string|null
     */
    private ?string $category;

    /**
     * @var string|null
     */
    private ?string $image;

    /**
     * @var string|null
     */
    private ?string $lightDocument;

    /**
     * @var string|null
     */
    private ?string $summaryDocument;

    /**
     * @var string|null
     */
    private ?string $detailedDocument;

    /**
     * @var string|null
     */
    private ?string $trends;

    /**
     * @var string|null
     */
    private ?string $level;

    /**
     * @param string|null $type
     * @param int|null $year
     * @param string|null $category
     * @param string|null $image
     * @param string|null $lightDocument
     * @param string|null $summaryDocument
     * @param string|null $detailedDocument
     * @param string|null $trends
     * @param string|null $level
     */
    public function __construct(
        ?string $type,
        ?int $year,
        ?string $category,
        ?string $image,
        ?string $lightDocument,
        ?string $summaryDocument,
        ?string $detailedDocument,
        ?string $trends,
        ?string $level
    )
    {
        $this->type = $type;
        $this->year = $year;
        $this->category = $category;
        $this->image = $image;
        $this->lightDocument = $lightDocument;
        $this->summaryDocument = $summaryDocument;
        $this->detailedDocument = $detailedDocument;
        $this->trends = $trends;
        $this->level = $level;
    }

    /**
     * @param array $item
     * @return self
     */
    public static function createFromCsv(array $item): self
    {
        return new self(
            $item[0] ?? null,
            intval($item[1] ?? null),
            $item[2] ?? null,
            $item[3] ?? null,
            $item[4] ?? null,
            $item[5] ?? null,
                $item[6] ?? null,
                $item[7] ?? null,
            $item[8] ?? null
        );
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
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
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->image ? wp_get_attachment_image_url($this->image, 'full') : get_template_directory_uri() . '/assets/img/no-image.png';
    }

    /**
     * @return string|null
     */
    public function getLightDocument(): ?string
    {
        return $this->lightDocument;
    }

    /**
     * @return string|null
     */
    public function getLightDocumentUrl(): ?string
    {
        if ($this->lightDocument) {
            return wp_get_attachment_url($this->lightDocument) ?: null;
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getLightDocumentSize(): ?int
    {
        if ($this->lightDocument) {
            return $this->getAttachmentFileSize($this->lightDocument);
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getSummaryDocument(): ?string
    {
        return $this->summaryDocument;
    }

    /**
     * @return string|null
     */
    public function getSummaryDocumentUrl(): ?string
    {
        if ($this->summaryDocument) {
            return wp_get_attachment_url($this->summaryDocument) ?: null;
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getSummaryDocumentSize(): ?int
    {
        if ($this->summaryDocument) {
            return $this->getAttachmentFileSize($this->summaryDocument);
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getDetailedDocument(): ?string
    {
        return $this->detailedDocument;
    }

    /**
     * @return string|null
     */
    public function getDetailedDocumentUrl(): ?string
    {
        if ($this->detailedDocument) {
            return wp_get_attachment_url($this->detailedDocument) ?: null;
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getDetailedDocumentSize(): ?int
    {
        if ($this->detailedDocument) {
            return $this->getAttachmentFileSize($this->detailedDocument);
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

    /**
     * @return string|null
     */
    public function getTrends(): ?string
    {
        return $this->trends;
    }

    /**
     * @return string
     */
    public function getTrendsLabelClasses(): string
    {
        $classes = [];

        switch (true) {
            case $this->trends === '減少':
                // $classes[] = 'c-label--org';
                $classes[] = 'arw-down';
                break;
            case $this->trends === '増加':
                // $classes[] = 'c-label--pink';
                $classes[] = 'arw-up';
                break;
            case $this->trends === '横ばい':
                $classes[] = 'arw-middle';
                break;
        }

        return implode(' ', $classes);
    }

    /**
     * @return string|null
     */
    public function getLevel(): ?string
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getLevelLabelClasses(): string
    {
        $classes = [];

        switch (true) {
            case $this->level === '低位':
                $classes[] = 'c-label--pink';
                break;
            case $this->level === '中位':
                $classes[] = 'c-label--org';
                break;
            case $this->level === '高位':
                $classes[] = 'c-label--grn';
                break;
        }

        return implode(' ', $classes);
    }
}