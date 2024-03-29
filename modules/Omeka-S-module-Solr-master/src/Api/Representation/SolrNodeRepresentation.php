<?php

/*
 * Copyright BibLibre, 2016-2017
 * Copyright Daniel Berthereau 2018
 *
 * This software is governed by the CeCILL license under French law and abiding
 * by the rules of distribution of free software.  You can use, modify and/ or
 * redistribute the software under the terms of the CeCILL license as circulated
 * by CEA, CNRS and INRIA at the following URL "http://www.cecill.info".
 *
 * As a counterpart to the access to the source code and rights to copy, modify
 * and redistribute granted by the license, users are provided only with a
 * limited warranty and the software's author, the holder of the economic
 * rights, and the successive licensors have only limited liability.
 *
 * In this respect, the user's attention is drawn to the risks associated with
 * loading, using, modifying and/or developing or reproducing the software by
 * the user in light of its specific status of free software, that may mean that
 * it is complicated to manipulate, and that also therefore means that it is
 * reserved for developers and experienced professionals having in-depth
 * computer knowledge. Users are therefore encouraged to load and test the
 * software's suitability as regards their requirements in conditions enabling
 * the security of their systems and/or data to be ensured and, more generally,
 * to use and operate it in the same conditions as regards security.
 *
 * The fact that you are presently reading this means that you have had
 * knowledge of the CeCILL license and that you accept its terms.
 */

namespace Solr\Api\Representation;

use Omeka\Api\Representation\AbstractEntityRepresentation;
use Omeka\Stdlib\Message;
use SolrClient;
use SolrException;
use Solr\Schema;

class SolrNodeRepresentation extends AbstractEntityRepresentation
{
    /**
     * {@inheritDoc}
     */
    public function getJsonLdType()
    {
        return 'o:SolrNode';
    }

    public function getJsonLd()
    {
        $entity = $this->resource;
        return [
            'o:name' => $entity->getName(),
            'o:settings' => $entity->getSettings(),
        ];
    }

    public function adminUrl($action = null, $canonical = false)
    {
        $url = $this->getViewHelper('Url');
        $params = [
            'action' => $action,
            'id' => $this->id(),
        ];
        $options = [
            'force_canonical' => $canonical,
        ];

        return $url('admin/solr/node-id', $params, $options);
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->resource->getName();
    }

    /**
     * @return array
     */
    public function settings()
    {
        return $this->resource->getSettings();
    }

    /**
     * @return array
     */
    public function clientSettings()
    {
        $settings = $this->settings();
        return (array) $settings['client'];
    }

    /**
     * @return string
     */
    public function clientUrl()
    {
        $settings = $this->clientSettings();
        $user = isset($settings['login']) ? $settings['login'] : '';
        $pass = isset($settings['password']) ? ':' . $settings['password'] : '';
        $pass = ($user || $pass) ? $pass . '@' : '';
        return (empty($settings['secure']) ? 'http://' : 'https://')
            . $user . $pass . $settings['hostname'] . ':' . $settings['port'] . '/' . $settings['path'];
    }

    /**
     * Get the url to the node without credentials.
     *
     * @return string
     */
    public function clientUrlAdmin()
    {
        $settings = $this->clientSettings();
        return (empty($settings['secure']) ? 'http://' : 'https://')
            . $settings['hostname'] . ':' . $settings['port'] . '/' . $settings['path'];
    }

    /**
     * @return string
     */
    public function clientUrlAdminBoard()
    {
        $settings = $this->clientSettings();
        return (empty($settings['secure']) ? 'http://' : 'https://')
            . $settings['hostname'] . ':' . $settings['port'] . '/solr/#/' . substr($settings['path'], 5);
    }

    /**
     * Check if Solr is working.
     *
     * @return string
     */
    public function status()
    {
        if (!extension_loaded('solr')) {
            return new Message('Solr module requires PHP Solr extension, which is not loaded.'); // @translate
        }

        $clientSettings = $this->clientSettings();
        $solrClient = new SolrClient($clientSettings);
        try {
            @$solrClient->ping();
        } catch (SolrException $e) {
            $logger = $this->getServiceLocator()->get('Omeka\Logger');
            $logger->err($e);
            $messages = explode("\n", $e->getMessage());
            return reset($messages);
        }

        // Check the schema too, in particular when there are credentials, but
        // the certificate is expired or incomplete.
        try {
            $this->schema()->getSchema();
        } catch (SolrException $e) {
            $logger = $this->getServiceLocator()->get('Omeka\Logger');
            $logger->err($e);
            $messages = explode("\n", $e->getMessage());
            return reset($messages);
        }

        // Check if the config bypass certificate check.
        if (!empty($clientSettings['secure'])) {
            $services = $this->getServiceLocator();
            if (!empty($services->get('Config')['solr']['config']['solr_bypass_certificate_check'])) {
                $logger = $services->get('Omeka\Logger');
                $logger->warn('Solr: the config bypasses the check of the certificate.'); // @translate
                return 'OK (warning: check of certificate disabled)'; // @translate
            }
        }

        return 'OK'; // @translate
    }

    /**
     * @param string $action
     * @param bool $canonical
     * @return string
     */
    public function mappingUrl($action = null, $canonical = false)
    {
        $url = $this->getViewHelper('Url');
        $params = [
            'action' => $action,
            'nodeId' => $this->id(),
        ];
        $options = [
            'force_canonical' => $canonical,
        ];
        return $url('admin/solr/node-id-mapping', $params, $options);
    }

    /**
     * @param string $resourceName
     * @param string $action
     * @param bool $canonical
     * @return string
     */
    public function resourceMappingUrl($resourceName, $action = null, $canonical = false)
    {
        $url = $this->getViewHelper('Url');
        $params = [
            'action' => $action,
            'nodeId' => $this->id(),
            'resourceName' => $resourceName,
        ];
        $options = [
            'force_canonical' => $canonical,
        ];
        return $url('admin/solr/node-id-mapping-resource', $params, $options);
    }

    /**
     * Get the schema for the node.
     *
     * @return \Solr\Schema\Schema
     */
    public function schema()
    {
        $services = $this->getServiceLocator();
        return $services->build(Schema::class, ['solr_node' => $this]);
    }
}
