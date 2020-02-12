<?php


namespace rollun\api\megaplan\Command;

use rollun\api\megaplan\Command\AbstractMegaplanCommand;
use rollun\api\megaplan\MegaplanClient;
use rollun\api\megaplan\Traits\CustomFieldMappingTrait;

/**
 * Class ReadEntityMegaplanCommand
 * @package Command
 */
class ReadEntityMegaplanCommand extends AbstractSpecificEntityMegaplanCommand
{

    use CustomFieldMappingTrait;

    /**
     * @var array
     */
    private $requestedFields;

    /**
     * @var array
     */
    private $extraFields;

    /**
     * ReadEntityMegaplanCommand constructor.
     * @param MegaplanClient $megaplanClient
     * @param string $uri
     * @param string $id
     * @param array $requestedFields
     * @param array $extraFields
     */
    public function __construct(
        MegaplanClient $megaplanClient,
        string $uri,
        string $id,
        array $requestedFields = [],
        array $extraFields = []
    )
    {
        parent::__construct($megaplanClient, $uri, $id);
        $this->requestedFields = $requestedFields;
        $this->extraFields = $extraFields;
    }

    /**
     * @return array
     */
    protected function getRequestParams()
    {
        return array_merge(parent::getRequestParams(), [
            'RequestedFields' => $this->requestedFields,
            'ExtraFields' => $this->extraFields,
        ]);
    }

    public function execute()
    {
        $item = parent::execute();

        return $this->customFieldMap($item);
    }
}
