<?php

namespace core\models\contracts;

use core\models\Model;
use core\models\ModelInterface;
use RtfHtmlPhp\Document;
use RtfHtmlPhp\Html\HtmlFormatter;

class ContractsModel extends Model implements ModelInterface
{
    protected array $fields = ['name', 'label', 'html', 'id'];
    private const TABLE_NAME = "contracts_table";

    public function __construct()
    {
        parent::__construct(ContractsValidator::class);
    }

    public function get(array $columnValue = []): array
    {
        if ($columnValue != []) {
            return $this->databaseSqlBuilder->select(self::TABLE_NAME, $columnValue);
        }

        return $this->databaseSqlBuilder->select(self::TABLE_NAME);
    }

    public function update(array $newInfo): bool
    {
        if (!$this->databaseSqlBuilder->update(self::TABLE_NAME, $this->fields, $newInfo, 'id')) {
            return false;
        }

        return true;
    }

    public function create(): bool
    {
        if (!isset($_FILES['file'])) {
            return false;
        }

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $new_name = time() . '.' . $ext;
        move_uploaded_file($_FILES['file']['tmp_name'], "../static/contracts/" . $new_name);

        $rtf = file_get_contents(BASE_PATH . "static/contracts/" . $new_name);
        $document = new Document($rtf);

        $formatter = new HtmlFormatter('UTF-8');

        $html = $formatter->Format($document);

        if (
            !$this->databaseSqlBuilder->insert(
            recordInfo: [
                    'name' => $_FILES['file']['name'],
                    'label' => $_FILES['file']['name'],
                    'html' => $html
                ],
            columns: $this->fields,
            tableName: self::TABLE_NAME
            )
        ) {
            return false;
        }

        return true;
    }

    public function delete(array $columnValues = [], string $column = "", mixed $value = NULL): bool
    {
        if (!$this->databaseSqlBuilder->delete($columnValues, self::TABLE_NAME)) {
            return false;
        }

        return true;
    }

    public function getContractInHTML(string $label = ""): string
    {
        $contract =  $this->databaseSqlBuilder->select(
            self::TABLE_NAME,
            ['column' => 'label', 'value' => $label]
        )[0];

        return $contract['html'];
    }

    public function getLastDocument(): array
    {
        $lastDocument = $this->databaseSqlBuilder->selectLastRecord(self::TABLE_NAME, 'id');

        return $lastDocument;
    }
}