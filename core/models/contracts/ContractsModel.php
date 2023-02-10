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
        $data = json_decode(file_get_contents("php://input"), true);
        $name = "";

        if ($data['label'] == 'contract') {
            $name = "Договор";
        }

        if ($data['label'] == 'attachment-2') {
            $name = "Приложение 2";
        }

        if ($data['label'] == 'attachment-1') {
            $name = "Приложение 1";
        }

        if ($data['label'] == 'voucher') {
            $name = "Ваучер (путевка)";
        }

        if (
            !$this->databaseSqlBuilder->insert(
            recordInfo: [
                    'name' => $name,
                    'label' => $data['label'],
                    'html' => $data['html']
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