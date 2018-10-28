<?php

namespace Jeffersonmartin\Buildhat\Generators;

use Jeffersonmartin\Buildhat\Common\CommandData;
use Jeffersonmartin\Buildhat\Utils\FileUtil;

class RepositoryGenerator extends BaseGenerator
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
        $this->path = $commandData->config->pathRepository;
        $this->fileName = $this->commandData->modelName.'Repository.php';
    }

    public function generate()
    {
        $templateData = get_template('repository', 'laravel-generator');

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $searchables = [];

        foreach ($this->commandData->fields as $field) {
            if ($field->isSearchable) {
                $searchables[] = "'".$field->name."'";
            }
        }

        $store_fields = [];

        foreach ($this->commandData->fields as $field) {
            if ($field->isFillable) {
                $store_fields[] = '$$MODEL_NAME_SNAKE$->'.$field->name.' = array_get($payload, \''.$field->name.'\', null);';
            }
        }

        $update_fields = [];

        foreach ($this->commandData->fields as $field) {
            if ($field->isFillable) {
                $update_fields[] = '$$MODEL_NAME_SNAKE$->'.$field->name.' = array_get($payload, \''.$field->name.'\', $$MODEL_NAME_SNAKE$->'.$field->name.');';
            }
        }

        $doc_store_param_fields = [];

        foreach ($this->commandData->fields as $field) {
            if ($field->isFillable) {
                $doc_store_param_fields[] = $field->fieldType.'|'.$field->name;
            }
        }

        $doc_update_param_fields = [];

        foreach ($this->commandData->fields as $field) {
            if ($field->isFillable) {
                $doc_update_param_fields[] = $field->fieldType.'|'.$field->name;
            }
        }

        $templateData = str_replace('$FIELDS$', implode(','.buildhat_nl_tab(1, 2), $searchables), $templateData);

        $templateData = str_replace('$STORE_FIELDS$', implode(buildhat_nl_tab(1, 2), $store_fields), $templateData);

        $templateData = str_replace('$UPDATE_FIELDS$', implode(buildhat_nl_tab(1, 2), $update_fields), $templateData);

        $templateData = str_replace('$DOC_STORE_PARAM_FIELDS$', implode(buildhat_nl_tab(1, 1).' *  '.buildhat_tabs(1), $doc_store_param_fields), $templateData);

        $templateData = str_replace('$DOC_UPDATE_PARAM_FIELDS$', implode(buildhat_nl_tab(1, 1).' *  '.buildhat_tabs(1), $doc_update_param_fields), $templateData);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $docsTemplate = get_template('docs.repository', 'laravel-generator');
        $docsTemplate = fill_template($this->commandData->dynamicVars, $docsTemplate);
        $docsTemplate = str_replace('$GENERATE_DATE$', date('F j, Y, g:i a T'), $docsTemplate);

        $templateData = str_replace('$DOCS$', $docsTemplate, $templateData);

        FileUtil::createFile($this->path, $this->fileName, $templateData);

        $this->commandData->commandComment("\nRepository created: ");
        $this->commandData->commandInfo($this->fileName);
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->fileName)) {
            $this->commandData->commandComment('Repository file deleted: '.$this->fileName);
        }
    }
}
