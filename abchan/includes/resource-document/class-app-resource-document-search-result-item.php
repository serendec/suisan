<?php
require_once __DIR__ . '/../trait-app-input-helper.php';

final class App_Resource_Document_Search_Result_Item
{
    use App_Input_Helper;

    /**
     * @var int|null
     */
    private ?int $year;

    /**
     * @var string|null
     */
    private ?string $type;

    /**
     * @var string|null
     */
    private ?string $number;

    /**
     * @var string|null
     */
    private ?string $subNumber;

    /**
     * @var string|null
     */
    private ?string $title;

    /**
     * @var int|null
     */
    private ?int $document;

    /**
     * @param int|null $year
     * @param string|null $type
     * @param string|null $number
     * @param string|null $subNumber
     * @param string|null $title
     * @param int|null $document
     */
    public function __construct(
        ?int $year,
        ?string $type,
        ?string $number,
        ?string $subNumber,
        ?string $title,
        ?int $document
    )
    {
        $this->year = $year;
        $this->type = $type;
        $this->number = $number;
        $this->subNumber = $subNumber;
        $this->title = $title;
        $this->document = $document;
    }

    /**
     * @param array $item
     * @return self
     */
    public static function createFromCsv(array $item): self
    {
        return new self(
            self::arrayInputExists($item, 0) ? intval($item[0]) : null,
            self::arrayInputExists($item, 1) ? strval($item[1]) : null,
            self::arrayInputExists($item, 2) ? strval($item[2]) : null,
            self::arrayInputExists($item, 3) ? strval($item[3]) : null,
            self::arrayInputExists($item, 4) ? strval($item[4]) : null,
            self::arrayInputExists($item, 5) ? intval($item[5]) : null
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
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @return string|null
     */
    public function getSubNumber(): ?string
    {
        return $this->subNumber;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return int|null
     */
    public function getDocument(): ?int
    {
        return $this->document;
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

    /**
     * @return string
     */
    public function getDocumentManageId(): string
    {
        $manageId = sprintf('FRA-SA%d-%s%s', $this->year, $this->type, $this->number);

        if (!empty($this->subNumber)) {
            $manageId .= '-' . $this->subNumber;
        }

        return $manageId;
    }
}