<?php

namespace Jeffersonmartin\Buildhat\Commands\Publish;

class PublishSchemaCommand extends PublishBaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'buildhat.publish:schemas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes schema directory.';

    private $templatesDir;

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->templatesDir = config(
            'buildhat.path.schema_files',
            base_path('resources/buildhat/schemas/')
        );

        $this->publishGeneratorSchemas();
    }

    /**
     * Publishes templates.
     */
    public function publishGeneratorSchemas()
    {
        $templatesPath = __DIR__.'/../../../schemas';

        return $this->publishDirectory($templatesPath, $this->templatesDir, 'Schemas');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }
}
