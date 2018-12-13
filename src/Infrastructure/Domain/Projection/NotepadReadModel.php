<?php

namespace Notepad\Infrastructure\Domain\Projection;

use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Notepad\Domain\Model\Notepad\NotepadNotFoundException;
use Prooph\EventStore\Projection\AbstractReadModel;

class NotepadReadModel extends AbstractReadModel
{
    /** @var Client */
    protected $client;

    /** @var string */
    protected $index = 'notepad_projection';

    /** @var string  */
    protected $type = 'notepad';

    /**
     * BacklogItemReadModel constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function init(): void
    {
        // TODO: create the index
    }

    public function isInitialized(): bool
    {
        // TODO: check if the index was created
        return true;
    }

    public function reset(): void
    {
        // TODO: clear the index
    }

    public function delete(): void
    {
        // TODO: Remove index
    }

    /**
     * @param string $id
     * @return mixed
     * @throws NotepadNotFoundException
     */
    public function get(string $id)
    {
        $document = [
            'index' => $this->index,
            'type' => $this->type,
            'id' => $id
        ];

        try {
            $result = $this->client->get($document);

            return $result['_source'];
        } catch (Missing404Exception $exception) {
            throw new NotepadNotFoundException($id, $exception);
        }
    }

    protected function createNotepad(string $id, array $notepadData)
    {
        $document['id'] = $id;
        $document['index'] = $this->index;
        $document['type'] = $this->type;
        $document['body'] = $notepadData;

        $this->client->index($document);
    }

    protected function addNote(string $id, array $noteData)
    {
        $document = [
            'index' => $this->index,
            'type' => $this->type,
            'id' => $id
        ];

        $result = $this->client->get($document);

        $body = $result['_source'];

        if (!isset($body['notes'])) {
            $body['notes'] = [];
        }

        $body['notes'][] = $noteData;

        $document['body'] = $body;
        $this->client->index($document);
    }

}