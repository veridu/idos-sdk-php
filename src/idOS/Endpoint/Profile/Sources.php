<?php

namespace idOS\Endpoint\Profile;

/**
 * Sources Class Endpoint.
 */
class Sources extends AbstractProfileEndpoint {
    /**
     * Creates a new source for the given username.
     *
     * @param string $name
     * @param string $ipaddr
     * @param array  $tags
     *
     * @return array Response
     */
    public function createNew(
        $name,
        array $tags
    ) {
        $array = [
            'name' => $name,
            'tags' => $tags
        ];

        return $this->sendPost(
            sprintf('/profiles/%s/sources', $this->userName),
            [],
            $array
        );
    }

    /**
     * Lists all sources.
     *
     * @param array $filters
     *
     * @return array Response
     */
    public function listAll(array $filters = []) {
        return $this->sendGet(
            sprintf('/profiles/%s/sources', $this->userName),
            $filters
        );
    }

    /**
     * Retrieves the source given its sourceId.
     *
     * @param int $sourceId
     *
     * @return array Response
     */
    public function getOne($sourceId) {
        return $this->sendGet(
            sprintf('/profiles/%s/sources/%s', $this->userName, $sourceId)
        );
    }

    /**
     * Updates a source in the given profile.
     *
     * @param int    $sourceId
     * @param string $ipaddr
     * @param string $tags
     *
     * @return array Response
     */
    public function updateOne($sourceId, array $tags, $otpCode = null, $ipaddr = '') {
        $array = [
            'tags' => $tags
        ];

        if ($otpCode !== null) {
            $array['otpCode'] = $otpCode;
        }

        return $this->sendPut(
            sprintf('/profiles/%s/sources/%s', $this->userName, $sourceId),
            [],
            $array
        );
    }

    /**
     * Deletes a source given its sourceId.
     *
     * @param string $sourceId
     *
     * @return array Response
     */
    public function deleteOne($sourceId) {
        return $this->sendDelete(
            sprintf('/profiles/%s/sources/%s', $this->userName, $sourceId)
        );
    }

    /**
     * Deletes all sources for the given username.
     *
     * @param array $filters
     *
     * @return array Response
     */
    public function deleteAll(array $filters = []) {
        return $this->sendDelete(
            sprintf('/profiles/%s/sources', $this->userName),
            $filters
        );
    }
}
