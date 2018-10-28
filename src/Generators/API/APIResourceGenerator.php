<?php

namespace Jeffersonmartin\Buildhat\Generators\API;

use Jeffersonmartin\Buildhat\Common\CommandData;
use Jeffersonmartin\Buildhat\Generators\BaseGenerator;
use Jeffersonmartin\Buildhat\Utils\FileUtil;

class APIResourceGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $fileName;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathResource;
        $this->fileName = $this->commandData->modelName.'Resource.php';
    }

    public function generate()
    {
        $templateData = get_template('resource', 'laravel-generator');

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $resource_fields = [];

        foreach ($this->commandData->fields as $field) {
            // Add cast for dates
            if ($field->fieldType == 'datetime') {
                $resource_fields[] = '\''.$field->name.'\' => (string)$this->'.$field->name;
            } else {
                $resource_fields[] = '\''.$field->name.'\' => $this->'.$field->name;
            }
        }

        $templateData = str_replace('$RESOURCE_FIELDS$', implode(','.buildhat_nl_tab(1, 3), $resource_fields), $templateData);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        FileUtil::createFile($this->path, $this->fileName, $templateData);

        $this->commandData->commandComment("\nResource created: ");
        $this->commandData->commandInfo($this->fileName);
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->fileName)) {
            $this->commandData->commandComment('Resource file deleted: '.$this->fileName);
        }
    }
}
