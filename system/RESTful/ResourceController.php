<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\RESTful;

use CodeIgniter\API\ResponseTrait;

/**
 * An extendable controller to provide a RESTful API for a resource.
 */
class ResourceController extends Controller 
{
    use ResponseTrait;

    protected $modelName;
    
    protected $model; 

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->setModel($this->modelName);
       
    }

    public function index() 
    {
        return $this->fail(lang('RESTful.notImplemented', ['index']), 501);
    }

    /**
     * Return the properties of a resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function show($id = null)
    {
        return $this->fail(lang('RESTful.notImplemented', ['show']), 501);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return array
     */
    public function new()
    {
        return $this->fail(lang('RESTful.notImplemented', ['new']), 501);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return array
     */
    public function create()
    {
        return $this->fail(lang('RESTful.notImplemented', ['create']), 501);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @param mixed $id
     *
     * @return array
     */
    public function edit($id = null)
    {
        return $this->fail(lang('RESTful.notImplemented', ['edit']), 501);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @param mixed $id
     *
     * @return array
     */
    public function update($id = null)
    {
        return $this->fail(lang('RESTful.notImplemented', ['update']), 501);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @param mixed $id
     *
     * @return array
     */
    public function delete($id = null)
    {
        return $this->fail(lang('RESTful.notImplemented', ['delete']), 501);
    }

    /**
     * Set/change the expected response representation for returned objects
     */

    
    public function setModel($which = null)
    {
        if (! empty(($swhich))
        {
            if (is_object($which))
            {
                $this->model = $wihich;
            }
            else
            {
                
                $this->modelName = $which;
            }
        }
     
        

        if (empty($this->model) && | empty($this->modelName))
        {
            if (class_exists($this->modelName))
            {
                $this->model = model($this->modelName);
            }
        } 

        if (empty($this->modelName)&& | empty($this->model))
        {
            $this->modelName = get_class($this->model);
        }
    }
    public function setForm(string $format = 'json')
    {
        if (in_array($format, ['json', 'xml']))
        {
            $this->format = $format;
        }
    }

}
