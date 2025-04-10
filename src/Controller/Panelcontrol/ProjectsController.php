<?php

namespace App\Controller\Panelcontrol;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Network\Session\DatabaseSession;
use Cake\Controller\Component\FlashComponent;

class ProjectsController extends AppController
{
    public function properties()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Properties";

        $this->set("title", $title);

        $propertiesTable = TableRegistry::get("Properties");

        $conditions = [];

        $order = ["Properties.id" => "DESC"];

        $properties = $propertiesTable
            ->find("all", ["conditions" => $conditions, "order" => $order])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("properties", $properties);
    }

    public function addProperty()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Properties";

        $this->set("title", $title);

        $propertiesTable = TableRegistry::get("Properties");

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $title = isset($this->request->getData()["Property"]["title"])
                ? trim($this->request->getData()["Property"]["title"])
                : "";

            $remark = isset($this->request->getData()["Property"]["remark"])
                ? trim($this->request->getData()["Property"]["remark"])
                : "";

            $status = isset($this->request->getData()["Property"]["status"])
                ? trim($this->request->getData()["Property"]["status"])
                : "";

            if (!empty($title) && !empty($remark) && !empty($status)) {
                $propertyData = $propertiesTable->newEmptyEntity();

                $propertyData->title = $title;

                $propertyData->remark = $remark;

                $propertyData->status = $status;

                if ($propertiesTable->save($propertyData)) {
                    $this->Flash->success(
                        __(
                            "Congratulations! Property has been added successfully."
                        )
                    );

                    return $this->redirect($this->backend_url ."/projects/add-property");
                }
            } else {
                $this->Flash->error(__("Please fill all required fields."));
            }
        }
    }

    public function editProperty($encPropertyId)
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Roi | Edit Property";

        $this->set("title", $title);

        $propertiesTable = TableRegistry::get("Properties");

        $emisTable = TableRegistry::get("Emis");

        if (!isset($encPropertyId)) {
            return $this->redirect($this->backend_url . "/projects/properties");
        }

        $propertyId = base64_decode($encPropertyId);

        $conditions = ["Properties.id" => $propertyId];

        $order = ["Properties.id" => "DESC"];

        $property = $propertiesTable
            ->find("all", ["conditions" => $conditions, "order" => $order])
            ->contain(["Emis"])
            ->enableAutoFields(true)
            ->first();

        if (empty($property)) {
            return $this->redirect($this->backend_url . "/properties/index");
        }

        $this->set("property", $property);

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $title = isset($this->request->getData()["Property"]["title"])
                ? trim($this->request->getData()["Property"]["title"])
                : "";

            $remark = isset($this->request->getData()["Property"]["remark"])
                ? trim($this->request->getData()["Property"]["remark"])
                : "";

            $status = isset($this->request->getData()["Property"]["status"])
                ? trim($this->request->getData()["Property"]["status"])
                : "";

            if (!empty($title) && !empty($remark) && !empty($status)) {
                $propertyData = $propertiesTable->get($propertyId);

                $propertyData->title = $title;

                $propertyData->remark = $remark;

                $propertyData->status = $status;

                if ($propertiesTable->save($propertyData)) {
                    $this->Flash->success(
                        __(
                            "Congratulations! Property has been added successfully."
                        )
                    );

                    return $this->redirect($this->backend_url . "/projects/edit-property/".$encPropertyId);
                }
            } else {
                $this->Flash->error(__("Please fill all required fields."));
            }
        }
    }

    public function changeStatus($encStatus, $encPropertyId)
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Roi | Edit Property";

        $this->set("title", $title);

        $propertiesTable = TableRegistry::get("Properties");

        if (!isset($encStatus) || !isset($encPropertyId)) {
            return $this->redirect($this->backend_url . "/projects/properties");
        }

        $status = base64_decode($encStatus);

        $propertyId = base64_decode($encPropertyId);

        $conditions = ["Properties.id" => $propertyId];

        $order = ["Properties.id" => "DESC"];

        $property = $propertiesTable
            ->find("all", ["conditions" => $conditions, "order" => $order])
            ->contain(["Emis"])
            ->enableAutoFields(true)
            ->first();

        if (empty($property)) {
            return $this->redirect($this->backend_url . "/properties/index");
        }

        $propertyData = $propertiesTable->get($propertyId);

        $propertyData->status = $status;

        $propertiesTable->save($propertyData);

        $this->Flash->success(
            __("Congratulations! Status has been updated successfully.")
        );

        return $this->redirect($this->backend_url . "/projects/properties");

        $this->autoRender = false;
    }

    public function sites()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Sites";

        $this->set("title", $title);

        $sitesTable = TableRegistry::get("Sites");

        $join = [
            [
                "table" => "properties",

                "alias" => "Properties",

                "type" => "INNER",

                "conditions" => ["Properties.id = Sites.property_id"],
            ],
        ];

        $conditions = [];

        $order = ["Sites.id" => "DESC"];

        $fields = ["Properties.id", "Properties.title"];

        $sites = $sitesTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("sites", $sites);
    }

    public function addSite()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Add Site";

        $this->set("title", $title);

        $propertiesTable = TableRegistry::get("Properties");

        $sitesTable = TableRegistry::get("Sites");

        $attachmentsTable = TableRegistry::get("Attachments");

        $conditions = [
            "Properties.status" => 1,
        ];

        $order = ["Properties.id" => "DESC"];

        $properties = $propertiesTable
            ->find("all", ["conditions" => $conditions, "order" => $order])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("properties", $properties);

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $property_id = isset(
                $this->request->getData()["Site"]["property_id"]
            )
                ? trim($this->request->getData()["Site"]["property_id"])
                : "";

            $title = isset($this->request->getData()["Site"]["title"])
                ? trim($this->request->getData()["Site"]["title"])
                : "";

            $remark = isset($this->request->getData()["Site"]["remark"])
                ? trim($this->request->getData()["Site"]["remark"])
                : "";

            $status = isset($this->request->getData()["Site"]["status"])
                ? trim($this->request->getData()["Site"]["status"])
                : "";

            if (
                !empty($property_id) &&
                !empty($title) &&
                !empty($remark) &&
                !empty($status)
            ) {
                $siteData = $sitesTable->newEmptyEntity();

                $siteData->property_id = $property_id;

                $siteData->attachment_id = isset(
                    $this->request->getData()["Attachment"]["attachment_id"][0]
                )
                    ? $this->request->getData()["Attachment"][
                        "attachment_id"
                    ][0]
                    : "";

                $siteData->title = $title;

                $siteData->remark = $remark;

                $siteData->status = $status;

                if ($sitesTable->save($siteData)) {
                    $siteId = $siteData->id;

                    if (
                        isset(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        ) &&
                        !empty(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        )
                    ) {
                        $attachmentData = $attachmentsTable->get(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        );

                        $attachmentData->reference_id = $siteId;

                        $attachmentData->reference_type = "site";

                        $attachmentData->caption = isset(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ]["caption"][0]
                        )
                            ? $this->request->getData()["Attachment"][
                                "attachment_id"
                            ]["caption"][0]
                            : "";

                        $attachmentsTable->save($attachmentData);
                    }

                    $this->Flash->success(
                        __("Congratulations! Site has been added successfully.")
                    );

                    return $this->redirect(
                        $this->backend_url . "/projects/add-site"
                    );
                }
            } else {
                $this->Flash->error(__("Please fill all required fields."));
            }
        }
    }

    public function editSite($encSiteId)
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Edit Site";

        $this->set("title", $title);

        $propertiesTable = TableRegistry::get("Properties");

        $sitesTable = TableRegistry::get("Sites");

        $attachmentsTable = TableRegistry::get("Attachments");

        if (empty($encSiteId)) {
            return $this->redirect($this->backend_url . "/projects/sites");
        }

        $siteId = base64_decode($encSiteId);

        $join = [
            [
                "table" => "attachments",

                "alias" => "Attachments",

                "type" => "LEFT",

                "conditions" => ["Attachments.id = Sites.attachment_id"],
            ],
        ];

        $conditions = [
            "Sites.id" => $siteId,
        ];

        $fields = ["Attachments.id", "Attachments.file", "Attachments.caption"];

        $siteInfo = $sitesTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
            ])
            ->enableAutoFields(true)
            ->first();

        if (empty($siteInfo)) {
            return $this->redirect($this->backend_url . "/projects/sites");
        }

        $this->set("siteInfo", $siteInfo);

        /*echo '<pre>';

        print_r($siteInfo);exit;*/

        $conditions = [
            "Properties.status" => 1,
        ];

        $order = ["Properties.id" => "DESC"];

        $properties = $propertiesTable
            ->find("all", ["conditions" => $conditions, "order" => $order])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("properties", $properties);

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $property_id = isset(
                $this->request->getData()["Site"]["property_id"]
            )
                ? trim($this->request->getData()["Site"]["property_id"])
                : "";

            $title = isset($this->request->getData()["Site"]["title"])
                ? trim($this->request->getData()["Site"]["title"])
                : "";

            $remark = isset($this->request->getData()["Site"]["remark"])
                ? trim($this->request->getData()["Site"]["remark"])
                : "";

            $status = isset($this->request->getData()["Site"]["status"])
                ? trim($this->request->getData()["Site"]["status"])
                : "";

            if (
                !empty($property_id) &&
                !empty($title) &&
                !empty($remark) &&
                !empty($status)
            ) {
                $siteData = $sitesTable->get($siteId);

                $siteData->property_id = $property_id;

                $siteData->attachment_id = isset(
                    $this->request->getData()["Attachment"]["attachment_id"][0]
                )
                    ? $this->request->getData()["Attachment"][
                        "attachment_id"
                    ][0]
                    : "";

                $siteData->title = $title;

                $siteData->remark = $remark;

                $siteData->status = $status;

                if ($sitesTable->save($siteData)) {
                    if (
                        isset(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        ) &&
                        !empty(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        )
                    ) {
                        $attachmentData = $attachmentsTable->get(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        );

                        $attachmentData->reference_id = $siteId;

                        $attachmentData->reference_type = "site";

                        $attachmentData->caption = isset(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ]["caption"][0]
                        )
                            ? $this->request->getData()["Attachment"][
                                "attachment_id"
                            ]["caption"][0]
                            : "";

                        $attachmentsTable->save($attachmentData);
                    }

                    $this->Flash->success(
                        __(
                            "Congratulations! Site has been updated successfully."
                        )
                    );

                    return $this->redirect(
                        $this->backend_url . "/projects/edit-site/".$encSiteId
                    );
                }
            } else {
                $this->Flash->error(__("Please fill all required fields."));
            }
        }
    }

    public function blocks()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Blocks";

        $this->set("title", $title);

        $blocksTable = TableRegistry::get("Blocks");

        $join = [
            [
                "table" => "properties",

                "alias" => "Properties",

                "type" => "INNER",

                "conditions" => ["Properties.id = Blocks.property_id"],
            ],

            [
                "table" => "sites",

                "alias" => "Sites",

                "type" => "INNER",

                "conditions" => ["Sites.id = Blocks.site_id"],
            ],
        ];

        $conditions = [];

        $order = ["Sites.id" => "DESC"];

        $fields = [
            "Properties.id",
            "Properties.title",
            "Sites.id",
            "Sites.title",
        ];

        $blocks = $blocksTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("blocks", $blocks);
    }

    public function addBlock()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Add Block";

        $this->set("title", $title);

        $propertiesTable = TableRegistry::get("Properties");

        $sitesTable = TableRegistry::get("Sites");

        $blocksTable = TableRegistry::get("Blocks");

        $attachmentsTable = TableRegistry::get("Attachments");

        $conditions = [
            "Properties.status" => 1,
        ];

        $order = ["Properties.id" => "DESC"];

        $properties = $propertiesTable
            ->find("all", ["conditions" => $conditions, "order" => $order])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("properties", $properties);

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $property_id = isset(
                $this->request->getData()["Block"]["property_id"]
            )
                ? trim($this->request->getData()["Block"]["property_id"])
                : "";

            $site_id = isset($this->request->getData()["Block"]["site_id"])
                ? trim($this->request->getData()["Block"]["site_id"])
                : "";

            $title = isset($this->request->getData()["Block"]["title"])
                ? trim($this->request->getData()["Block"]["title"])
                : "";

            $remark = isset($this->request->getData()["Block"]["remark"])
                ? trim($this->request->getData()["Block"]["remark"])
                : "";

            $status = isset($this->request->getData()["Block"]["status"])
                ? trim($this->request->getData()["Block"]["status"])
                : "";

            if (
                !empty($property_id) &&
                !empty($site_id) &&
                !empty($title) &&
                !empty($remark) &&
                !empty($status)
            ) {
                $blockData = $blocksTable->newEmptyEntity();

                $blockData->property_id = $property_id;

                $blockData->site_id = $site_id;

                $blockData->attachment_id = isset(
                    $this->request->getData()["Attachment"]["attachment_id"][0]
                )
                    ? $this->request->getData()["Attachment"][
                        "attachment_id"
                    ][0]
                    : "";

                $blockData->title = $title;

                $blockData->remark = $remark;

                $blockData->status = $status;

                if ($blocksTable->save($blockData)) {
                    $blockId = $blockData->id;

                    if (
                        isset(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        ) &&
                        !empty(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        )
                    ) {
                        $attachmentData = $attachmentsTable->get(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        );

                        $attachmentData->reference_id = $blockId;

                        $attachmentData->reference_type = "block";

                        $attachmentData->caption = isset(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ]["caption"][0]
                        )
                            ? $this->request->getData()["Attachment"][
                                "attachment_id"
                            ]["caption"][0]
                            : "";

                        $attachmentsTable->save($attachmentData);
                    }

                    $this->Flash->success(
                        __(
                            "Congratulations! Block has been added successfully."
                        )
                    );

                    return $this->redirect(
                        $this->backend_url . "/projects/add-block"
                    );
                }
            } else {
                $this->Flash->error(__("Please fill all required fields."));
            }
        }
    }

    public function editBlock($encBlockId)
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Add Block";

        $this->set("title", $title);

        $propertiesTable = TableRegistry::get("Properties");

        $sitesTable = TableRegistry::get("Sites");

        $blocksTable = TableRegistry::get("Blocks");

        $attachmentsTable = TableRegistry::get("Attachments");

        if (empty($encBlockId)) {
            return $this->redirect($this->backend_url . "/projects/blocks");
        }

        $blockId = base64_decode($encBlockId);

        $join = [
            [
                "table" => "attachments",

                "alias" => "Attachments",

                "type" => "LEFT",

                "conditions" => ["Attachments.id = Blocks.attachment_id"],
            ],
        ];

        $conditions = [
            "Blocks.id" => $blockId,
        ];

        $fields = ["Attachments.id", "Attachments.file", "Attachments.caption"];

        $blockInfo = $blocksTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
            ])
            ->enableAutoFields(true)
            ->first();

        if (empty($blockInfo)) {
            return $this->redirect($this->backend_url . "/projects/blocks");
        }

        $this->set("blockInfo", $blockInfo);

        $conditions = [
            "Sites.id" => $blockInfo->site_id,
        ];

        $fields = ["Sites.id", "Sites.title"];

        $siteInfo = $sitesTable
            ->find("all", ["fields" => $fields, "conditions" => $conditions])
            ->first();

        $this->set("siteInfo", $siteInfo);

        /*echo '<pre>';

        print_r($blockInfo);exit;*/

        $conditions = [
            "Properties.status" => 1,
        ];

        $order = ["Properties.id" => "DESC"];

        $properties = $propertiesTable
            ->find("all", ["conditions" => $conditions, "order" => $order])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("properties", $properties);

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $property_id = isset(
                $this->request->getData()["Block"]["property_id"]
            )
                ? trim($this->request->getData()["Block"]["property_id"])
                : "";

            $site_id = isset($this->request->getData()["Block"]["site_id"])
                ? trim($this->request->getData()["Block"]["site_id"])
                : "";

            $title = isset($this->request->getData()["Block"]["title"])
                ? trim($this->request->getData()["Block"]["title"])
                : "";

            $remark = isset($this->request->getData()["Block"]["remark"])
                ? trim($this->request->getData()["Block"]["remark"])
                : "";

            $status = isset($this->request->getData()["Block"]["status"])
                ? trim($this->request->getData()["Block"]["status"])
                : "";

            if (
                !empty($property_id) &&
                !empty($site_id) &&
                !empty($title) &&
                !empty($remark) &&
                !empty($status)
            ) {
                $blockData = $blocksTable->get($blockId);

                $blockData->property_id = $property_id;

                $blockData->site_id = $site_id;

                $blockData->attachment_id = isset(
                    $this->request->getData()["Attachment"]["attachment_id"][0]
                )
                    ? $this->request->getData()["Attachment"][
                        "attachment_id"
                    ][0]
                    : "";

                $blockData->title = $title;

                $blockData->remark = $remark;

                $blockData->status = $status;

                if ($blocksTable->save($blockData)) {
                    if (
                        isset(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        ) &&
                        !empty(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        )
                    ) {
                        $attachmentData = $attachmentsTable->get(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        );

                        $attachmentData->reference_id = $blockId;

                        $attachmentData->reference_type = "block";

                        $attachmentData->caption = isset(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ]["caption"][0]
                        )
                            ? $this->request->getData()["Attachment"][
                                "attachment_id"
                            ]["caption"][0]
                            : "";

                        $attachmentsTable->save($attachmentData);
                    }

                    $this->Flash->success(
                        __(
                            "Congratulations! Block has been updated successfully."
                        )
                    );

                    return $this->redirect(
                        $this->backend_url . "projects/edit-block/".$encBlockId
                    );
                }
            } else {
                $this->Flash->error(__("Please fill all required fields."));
            }
        }
    }

    public function plots()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Plots";

        $this->set("title", $title);

        $plotsTable = TableRegistry::get("Plots");

        $join = [
            [
                "table" => "properties",

                "alias" => "Properties",

                "type" => "LEFT",

                "conditions" => ["Properties.id = Plots.property_id"],
            ],

            [
                "table" => "sites",

                "alias" => "Sites",

                "type" => "LEFT",

                "conditions" => ["Sites.id = Plots.site_id"],
            ],

            [
                "table" => "blocks",

                "alias" => "Blocks",

                "type" => "LEFT",

                "conditions" => ["Blocks.id = Plots.block_id"],
            ],
        ];

        $conditions = [];

        $order = ["Plots.id" => "DESC"];

        $fields = [
            "Properties.id",
            "Properties.title",
            "Sites.id",
            "Sites.title",
            "Blocks.id",
            "Blocks.title",
        ];

        $group = ["Plots.id"];

        $plots = $plotsTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
                "order" => $order,
                "group" => $group,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("plots", $plots);

        /*echo '<pre>';

        print_r($plots);exit;*/
    }

    public function addPlot()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Add Plot";

        $this->set("title", $title);

        $propertiesTable = TableRegistry::get("Properties");

        $sitesTable = TableRegistry::get("Sites");

        $blocksTable = TableRegistry::get("Blocks");

        $plotsTable = TableRegistry::get("Plots");

        $attachmentsTable = TableRegistry::get("Attachments");

        $conditions = [
            "Properties.status" => 1,
        ];

        $order = ["Properties.id" => "DESC"];

        $properties = $propertiesTable
            ->find("all", ["conditions" => $conditions, "order" => $order])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("properties", $properties);

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $property_id = isset(
                $this->request->getData()["Plot"]["property_id"]
            )
                ? trim($this->request->getData()["Plot"]["property_id"])
                : "";

            $site_id = isset($this->request->getData()["Plot"]["site_id"])
                ? trim($this->request->getData()["Plot"]["site_id"])
                : "";

            $block_id = isset($this->request->getData()["Plot"]["block_id"])
                ? trim($this->request->getData()["Plot"]["block_id"])
                : "";

            $plot_number = isset(
                $this->request->getData()["Plot"]["plot_number"]
            )
                ? trim($this->request->getData()["Plot"]["plot_number"])
                : "";

            $name = isset($this->request->getData()["Plot"]["name"])
                ? trim($this->request->getData()["Plot"]["name"])
                : "";

            $length = isset($this->request->getData()["Plot"]["length"])
                ? trim($this->request->getData()["Plot"]["length"])
                : "";

            $width = isset($this->request->getData()["Plot"]["width"])
                ? trim($this->request->getData()["Plot"]["width"])
                : "";

            $area = isset($this->request->getData()["Plot"]["area"])
                ? trim($this->request->getData()["Plot"]["area"])
                : "";

            $location = isset($this->request->getData()["Plot"]["location"])
                ? trim($this->request->getData()["Plot"]["location"])
                : "";

            $east = isset($this->request->getData()["Plot"]["east"])
                ? trim($this->request->getData()["Plot"]["east"])
                : "";

            $west = isset($this->request->getData()["Plot"]["west"])
                ? trim($this->request->getData()["Plot"]["west"])
                : "";

            $north = isset($this->request->getData()["Plot"]["north"])
                ? trim($this->request->getData()["Plot"]["north"])
                : "";

            $south = isset($this->request->getData()["Plot"]["south"])
                ? trim($this->request->getData()["Plot"]["south"])
                : "";

            $plc = isset($this->request->getData()["Plot"]["plc"])
                ? trim($this->request->getData()["Plot"]["plc"])
                : "";

            $edc = isset($this->request->getData()["Plot"]["edc"])
                ? trim($this->request->getData()["Plot"]["edc"])
                : "";

            $ifmc = isset($this->request->getData()["Plot"]["ifmc"])
                ? trim($this->request->getData()["Plot"]["ifmc"])
                : "";

            $bsp = isset($this->request->getData()["Plot"]["bsp"])
                ? trim($this->request->getData()["Plot"]["bsp"])
                : "";

            $status = isset($this->request->getData()["Plot"]["status"])
                ? trim($this->request->getData()["Plot"]["status"])
                : "";

            if (
                !empty($property_id) &&
                !empty($site_id) &&
                !empty($block_id) &&
                !empty($plot_number) &&
                !empty($name) &&
                !empty($area) &&
                !empty($status)
            ) {
                $plotData = $plotsTable->newEmptyEntity();

                $plotData->property_id = $property_id;

                $plotData->site_id = $site_id;

                $plotData->block_id = $block_id;

                $plotData->attachment_id = isset(
                    $this->request->getData()["Attachment"]["attachment_id"][0]
                )
                    ? $this->request->getData()["Attachment"][
                        "attachment_id"
                    ][0]
                    : "";

                $plotData->plot_number = $plot_number;

                $plotData->name = $name;

                $plotData->length = $length;

                $plotData->width = $width;

                $plotData->area = $area;

                $plotData->location = $location;

                $plotData->east = $east;

                $plotData->west = $west;

                $plotData->north = $north;

                $plotData->south = $south;

                $plotData->plc = $plc;

                $plotData->edc = $edc;

                $plotData->ifmc = $ifmc;

                $plotData->bsp = $bsp;

                $plotData->status = $status;

                if ($plotsTable->save($plotData)) {
                    $plotId = $plotData->id;

                    if (
                        isset(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        ) &&
                        !empty(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        )
                    ) {
                        $attachmentData = $attachmentsTable->get(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        );

                        $attachmentData->reference_id = $plotId;

                        $attachmentData->reference_type = "plot";

                        $attachmentData->caption = isset(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ]["caption"][0]
                        )
                            ? $this->request->getData()["Attachment"][
                                "attachment_id"
                            ]["caption"][0]
                            : "";

                        $attachmentsTable->save($attachmentData);
                    }

                    $this->Flash->success(
                        __("Congratulations! Plot has been added successfully.")
                    );

                    return $this->redirect(
                        $this->backend_url . "/projects/add-plot"
                    );
                }
            } else {
                $this->Flash->error(__("Please fill all required fields."));
            }
        }
    }

    public function editPlot($encPlotId)
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Edit Plot";

        $this->set("title", $title);

        $propertiesTable = TableRegistry::get("Properties");

        $sitesTable = TableRegistry::get("Sites");

        $blocksTable = TableRegistry::get("Blocks");

        $plotsTable = TableRegistry::get("Plots");

        $attachmentsTable = TableRegistry::get("Attachments");

        if (empty($encPlotId)) {
            return $this->redirect($this->backend_url . "/projects/blocks");
        }

        $plotId = base64_decode($encPlotId);

        $join = [
            [
                "table" => "attachments",

                "alias" => "Attachments",

                "type" => "LEFT",

                "conditions" => ["Attachments.id = Plots.attachment_id"],
            ],
        ];

        $conditions = [
            "Plots.id" => $plotId,
        ];

        $fields = ["Attachments.id", "Attachments.file", "Attachments.caption"];

        $plotInfo = $plotsTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
            ])
            ->enableAutoFields(true)
            ->first();

        if (empty($plotInfo)) {
            return $this->redirect($this->backend_url . "/projects/blocks");
        }

        $this->set("plotInfo", $plotInfo);

        $conditions = [
            "Sites.id" => $plotInfo->site_id,
        ];

        $fields = ["Sites.id", "Sites.title"];

        $siteInfo = $sitesTable
            ->find("all", ["fields" => $fields, "conditions" => $conditions])
            ->first();

        $this->set("siteInfo", $siteInfo);

        $conditions = [
            "Blocks.id" => $plotInfo->block_id,
        ];

        $fields = ["Blocks.id", "Blocks.title"];

        $blockInfo = $blocksTable
            ->find("all", ["fields" => $fields, "conditions" => $conditions])
            ->first();

        $this->set("blockInfo", $blockInfo);

        /*echo '<pre>';

        print_r($blockInfo);exit;*/

        $conditions = [
            "Properties.status" => 1,
        ];

        $order = ["Properties.id" => "DESC"];

        $properties = $propertiesTable
            ->find("all", ["conditions" => $conditions, "order" => $order])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("properties", $properties);

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $property_id = isset(
                $this->request->getData()["Plot"]["property_id"]
            )
                ? trim($this->request->getData()["Plot"]["property_id"])
                : "";

            $site_id = isset($this->request->getData()["Plot"]["site_id"])
                ? trim($this->request->getData()["Plot"]["site_id"])
                : "";

            $block_id = isset($this->request->getData()["Plot"]["block_id"])
                ? trim($this->request->getData()["Plot"]["block_id"])
                : "";

            $plot_number = isset(
                $this->request->getData()["Plot"]["plot_number"]
            )
                ? trim($this->request->getData()["Plot"]["plot_number"])
                : "";

            $name = isset($this->request->getData()["Plot"]["name"])
                ? trim($this->request->getData()["Plot"]["name"])
                : "";

            $length = isset($this->request->getData()["Plot"]["length"])
                ? trim($this->request->getData()["Plot"]["length"])
                : "";

            $width = isset($this->request->getData()["Plot"]["width"])
                ? trim($this->request->getData()["Plot"]["width"])
                : "";

            $area = isset($this->request->getData()["Plot"]["area"])
                ? trim($this->request->getData()["Plot"]["area"])
                : "";

            $location = isset($this->request->getData()["Plot"]["location"])
                ? trim($this->request->getData()["Plot"]["location"])
                : "";

            $east = isset($this->request->getData()["Plot"]["east"])
                ? trim($this->request->getData()["Plot"]["east"])
                : "";

            $west = isset($this->request->getData()["Plot"]["west"])
                ? trim($this->request->getData()["Plot"]["west"])
                : "";

            $north = isset($this->request->getData()["Plot"]["north"])
                ? trim($this->request->getData()["Plot"]["north"])
                : "";

            $south = isset($this->request->getData()["Plot"]["south"])
                ? trim($this->request->getData()["Plot"]["south"])
                : "";

            $plc = isset($this->request->getData()["Plot"]["plc"])
                ? trim($this->request->getData()["Plot"]["plc"])
                : "";

            $edc = isset($this->request->getData()["Plot"]["edc"])
                ? trim($this->request->getData()["Plot"]["edc"])
                : "";

            $ifmc = isset($this->request->getData()["Plot"]["ifmc"])
                ? trim($this->request->getData()["Plot"]["ifmc"])
                : "";

            $bsp = isset($this->request->getData()["Plot"]["bsp"])
                ? trim($this->request->getData()["Plot"]["bsp"])
                : "";

            $status = isset($this->request->getData()["Plot"]["status"])
                ? trim($this->request->getData()["Plot"]["status"])
                : "";

            if (
                !empty($property_id) &&
                !empty($site_id) &&
                !empty($block_id) &&
                !empty($plot_number) &&
                !empty($name) &&
                !empty($area) &&
                !empty($status)
            ) {
                $plotData = $plotsTable->get($plotId);

                $plotData->property_id = $property_id;

                $plotData->site_id = $site_id;

                $plotData->block_id = $block_id;

                $plotData->attachment_id = isset(
                    $this->request->getData()["Attachment"]["attachment_id"][0]
                )
                    ? $this->request->getData()["Attachment"][
                        "attachment_id"
                    ][0]
                    : "";

                $plotData->plot_number = $plot_number;

                $plotData->name = $name;

                $plotData->length = $length;

                $plotData->width = $width;

                $plotData->area = $area;

                $plotData->location = $location;

                $plotData->east = $east;

                $plotData->west = $west;

                $plotData->north = $north;

                $plotData->south = $south;

                $plotData->plc = $plc;

                $plotData->edc = $edc;

                $plotData->ifmc = $ifmc;

                $plotData->bsp = $bsp;

                $plotData->status = $status;

                if ($plotsTable->save($plotData)) {
                    if (
                        isset(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        ) &&
                        !empty(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        )
                    ) {
                        $attachmentData = $attachmentsTable->get(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ][0]
                        );

                        $attachmentData->reference_id = $plotId;

                        $attachmentData->reference_type = "plot";

                        $attachmentData->caption = isset(
                            $this->request->getData()["Attachment"][
                                "attachment_id"
                            ]["caption"][0]
                        )
                            ? $this->request->getData()["Attachment"][
                                "attachment_id"
                            ]["caption"][0]
                            : "";

                        $attachmentsTable->save($attachmentData);
                    }

                    $this->Flash->success(
                        __(
                            "Congratulations! Plot has been updated successfully."
                        )
                    );

                    return $this->redirect(
                        $this->backend_url . "/projects/edit-plot/".$encPlotId
                    );
                }
            } else {
                $this->Flash->error(__("Please fill all required fields."));
            }
        }
    }

    public function addMultiplePlots()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Add Plot";

        $this->set("title", $title);

        $propertiesTable = TableRegistry::get("Properties");

        $sitesTable = TableRegistry::get("Sites");

        $blocksTable = TableRegistry::get("Blocks");

        $plotsTable = TableRegistry::get("Plots");

        $attachmentsTable = TableRegistry::get("Attachments");

        $conditions = [
            "Properties.status" => 1,
        ];

        $order = ["Properties.id" => "DESC"];

        $properties = $propertiesTable
            ->find("all", ["conditions" => $conditions, "order" => $order])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("properties", $properties);

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $property_id = isset(
                $this->request->getData()["Plot"]["property_id"]
            )
                ? trim($this->request->getData()["Plot"]["property_id"])
                : "";

            $site_id = isset($this->request->getData()["Plot"]["site_id"])
                ? trim($this->request->getData()["Plot"]["site_id"])
                : "";

            $block_id = isset($this->request->getData()["Plot"]["block_id"])
                ? trim($this->request->getData()["Plot"]["block_id"])
                : "";

            $tmp_name = isset(
                $this->request->getData()["plot_file"]["tmp_name"]
            )
                ? trim($this->request->getData()["plot_file"]["tmp_name"])
                : "";

            $file_name = isset($this->request->getData()["plot_file"]["name"])
                ? trim($this->request->getData()["plot_file"]["name"])
                : "";

            if (
                !empty($property_id) &&
                !empty($site_id) &&
                !empty($block_id) &&
                !empty($tmp_name) &&
                !empty($file_name)
            ) {
                $extFileName = explode(".", $file_name);

                $fileExt = trim($extFileName[count($extFileName) - 1]);

                if ($fileExt == "xls" || $fileExt == "xlsx") {
                    if ($_SERVER["DOCUMENT_ROOT"] == "C:/xampp/htdocs") {
                        require_once $_SERVER["DOCUMENT_ROOT"] .
                            "/aradhyamcity/webroot/classes/bulk_upload.php";
                    } else {
                        require_once $_SERVER["DOCUMENT_ROOT"] .
                            "/webroot/classes/bulk_upload.php";
                    }

                    $object = bulk_upload($tmp_name);

                    foreach ($object->getWorksheetIterator() as $worksheet) {
                        $highestRow = $worksheet->getHighestRow();

                        for ($i = 2; $i <= $highestRow; $i++) {
                            /*echo '0---'. $worksheet->getCellByColumnAndRow(0, 1)->getValue();

                            echo '<br>';

                            echo '1---'.$worksheet->getCellByColumnAndRow(1, 1)->getValue();

                            echo '<br>';

                            echo '2---'.$worksheet->getCellByColumnAndRow(2, 1)->getValue();

                            echo '<br>';

                            echo '3---'.$worksheet->getCellByColumnAndRow(3, 1)->getValue();

                            echo '<br>';

                            echo '4---'.$worksheet->getCellByColumnAndRow(4, 1)->getValue();

                            echo '<br>';

                            echo '5---'.$worksheet->getCellByColumnAndRow(5, 1)->getValue();

                            echo '<br>';

                            echo '6---'.$worksheet->getCellByColumnAndRow(6, 1)->getValue();

                            echo '<br>';

                            echo '7---'.$worksheet->getCellByColumnAndRow(7, 1)->getValue();

                            echo '<br>';

                            echo '8---'.$worksheet->getCellByColumnAndRow(8, 1)->getValue();

                            echo '<br>';

                            echo '9---'.$worksheet->getCellByColumnAndRow(9, 1)->getValue();

                            echo '<br>';

                            echo '10---'.$worksheet->getCellByColumnAndRow(10, 1)->getValue();

                            echo '<br>';

                            echo '11---'.$worksheet->getCellByColumnAndRow(11, 1)->getValue();

                            echo '<br>';

                            echo '12---'.$worksheet->getCellByColumnAndRow(12, 1)->getValue();

                            echo '<br>';

                            echo '13---'.$worksheet->getCellByColumnAndRow(13, 1)->getValue();

                            echo '<br>';

                            echo '14---'.$worksheet->getCellByColumnAndRow(14, 1)->getValue();

                            echo '<br>';

                            exit;*/

                            if (
                                !empty(
                                    trim(
                                        $worksheet
                                            ->getCellByColumnAndRow(0, $i)
                                            ->getValue()
                                    )
                                )
                            ) {
                                $plotData = $plotsTable->newEmptyEntity();

                                $plotData->property_id = $property_id;

                                $plotData->site_id = $site_id;

                                $plotData->block_id = $block_id;

                                $plotData->plot_number = $worksheet
                                    ->getCellByColumnAndRow(0, $i)
                                    ->getValue();

                                $plotData->name = $worksheet
                                    ->getCellByColumnAndRow(1, $i)
                                    ->getValue();

                                $plotData->area = $worksheet
                                    ->getCellByColumnAndRow(2, $i)
                                    ->getValue();

                                $plotData->plc = $worksheet
                                    ->getCellByColumnAndRow(3, $i)
                                    ->getValue();

                                $plotData->status = $worksheet
                                    ->getCellByColumnAndRow(4, $i)
                                    ->getValue();

                                $plotsTable->save($plotData);
                            }
                        }
                    }

                    $this->Flash->success(
                        __("Congratulations! Plot has been added successfully.")
                    );

                    return $this->redirect(
                        $this->backend_url . "/projects/add-multiple-plots"
                    );
                } else {
                    $this->Flash->error(
                        __("Please upload xls or xlsx file only.")
                    );
                }
            } else {
                $this->Flash->error(__("Please fill all required fields."));
            }
        }
    }

    public function plotPayment()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Plot Payment";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $plotPaymentsTable = TableRegistry::get("PlotPayments");

        $assignPlotsTable = TableRegistry::get("AssignPlots");

        $commissionsTable = TableRegistry::get("Commissions");

        $payoutsTable = TableRegistry::get("Payouts");

        $conditions = [
            "Users.role_id" => 2,
        ];

        $order = ["Users.username" => "ASC"];

        $join = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $fields = ["Details.id", "Details.first_name", "Details.last_name"];

        $users = $usersTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("users", $users);

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $user_id = isset(
                $this->request->getData()["PlotPayment"]["user_id"]
            )
                ? trim($this->request->getData()["PlotPayment"]["user_id"])
                : "";

            $number_of_unit = isset(
                $this->request->getData()["PlotPayment"]["number_of_unit"]
            )
                ? trim(
                    $this->request->getData()["PlotPayment"]["number_of_unit"]
                )
                : null;

            //$assign_plot_id = isset($this->request->getData()['PlotPayment']['assign_plot_id']) ? trim($this->request->getData()['PlotPayment']['assign_plot_id']) : '';

            $amount = isset($this->request->getData()["PlotPayment"]["amount"])
                ? trim($this->request->getData()["PlotPayment"]["amount"])
                : "";

            $payment_mode = isset(
                $this->request->getData()["PlotPayment"]["payment_mode"]
            )
                ? trim($this->request->getData()["PlotPayment"]["payment_mode"])
                : "";

            $bank = isset($this->request->getData()["PlotPayment"]["bank"])
                ? trim($this->request->getData()["PlotPayment"]["bank"])
                : "";

            $cheque_number = isset(
                $this->request->getData()["PlotPayment"]["cheque_number"]
            )
                ? trim(
                    $this->request->getData()["PlotPayment"]["cheque_number"]
                )
                : "";

            $transaction_id = isset(
                $this->request->getData()["PlotPayment"]["transaction_id"]
            )
                ? trim(
                    $this->request->getData()["PlotPayment"]["transaction_id"]
                )
                : "";

            $amount_date = isset(
                $this->request->getData()["PlotPayment"]["amount_date"]
            )
                ? trim($this->request->getData()["PlotPayment"]["amount_date"])
                : "";

            if (!empty($user_id) && !empty($amount) && !empty($payment_mode)) {
                $commission = $commissionsTable
                    ->find("all", ["conditions" => ["Commissions.status" => 1]])
                    ->enableAutoFields(true)
                    ->first();

                $plotPaymentData = $plotPaymentsTable->newEmptyEntity();

                $plotPaymentData->user_id = $user_id;

                $plotPaymentData->number_of_unit = $number_of_unit;

                $plotPaymentData->amount = $amount;

                $plotPaymentData->payment_mode = $payment_mode;

                $plotPaymentData->bank = $bank;

                $plotPaymentData->cheque_number = $cheque_number;

                $plotPaymentData->transaction_id = $transaction_id;

                $plotPaymentData->amount_date = $amount_date;

                $plotPaymentData->status = 1;

                if ($plotPaymentsTable->save($plotPaymentData)) {
                    $join = [
                        [
                            "table" => "details",

                            "alias" => "Details",

                            "type" => "INNER",

                            "conditions" => ["Details.user_id = Users.id"],
                        ],
                    ];

                    $conditions = [
                        "Users.id" => $user_id,
                    ];

                    $fields = [
                        "Details.id",
                        "Details.first_name",
                        "Details.last_name",
                        "Details.contact_no",
                    ];

                    $userData = $usersTable
                        ->find("all", [
                            "fields" => $fields,
                            "conditions" => $conditions,
                            "join" => $join,
                        ])
                        ->enableAutoFields(true)
                        ->first();

                    //$usersTable->addLevelIncome($user_id, $amount, 1, 10);

                    if (
                        isset($userData->sponsor_id) &&
                        !empty($userData->sponsor_id)
                    ) {
                        //echo 'sadas';exit;

                        $sponsorInfo = $usersTable
                            ->find("all", [
                                "conditions" => [
                                    "Users.id" => $userData->sponsor_id,
                                ],
                            ])
                            ->enableAutoFields(true)
                            ->first();

                        $sponsor = $usersTable->get($userData->sponsor_id);

                        if ($userData->position == "left") {
                            $sponsor->total_direct_acitve_left =
                                $sponsorInfo->total_direct_acitve_left +
                                $amount;
                        } else {
                            $sponsor->total_direct_acitve_right =
                                $sponsorInfo->total_direct_acitve_right +
                                $amount;
                        }

                        $usersTable->save($sponsor);

                        $directAmount = ($amount * 11) / 100;

                        $payout = $payoutsTable->newEmptyEntity();

                        $payout->upgraded_table_id = $user_id;

                        $payout->upagraded_user_id = $userData->sponsor_id;

                        $payout->direct_amount = $directAmount;

                        $payout->tax = isset($commission->tax)
                            ? $commission->tax
                            : 0;

                        $payout->admin_commission = isset($commission->amount)
                            ? $commission->amount
                            : 0;

                        $payoutsTable->save($payout);
                    }

                    $usersTable->updateParentsOnUpgrade(
                        $user_id,
                        $userData->parent_id,
                        $amount
                    );

                    $usersTable->makeClubMember($user_id, $amount);

                    if (!empty($number_of_unit)) {
                        $usersTable->updateParentsOnPackageUpgrade(
                            $user_id,
                            $userData->parent_id,
                            $number_of_unit
                        );
                    }

                    $template =
                        "Dear " .
                        $userData->Details["first_name"] .
                        " " .
                        $userData->Details["last_name"] .
                        "(" .
                        $userData->username .
                        "), Your Payment of Rs " .
                        $amount .
                        " is received. For help, please visit Jsksinfratech.com";

                    $sendSMS = $usersTable->sendSMS(
                        $template,
                        $userData->Details["contact_no"]
                    );

                    $this->Flash->success(
                        __(
                            "Congratulations! Payment has been received successfully."
                        )
                    );

                    return $this->redirect($this->backend_url ."/projects/plot-payment");
                }
            } else {
                $this->Flash->error(__("Please fill all required fields."));
            }
        }
    }

    public function deletePlotPayment()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . "Delete  Plot Payment";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $plotPaymentsTable = TableRegistry::get("PlotPayments");

        $assignPlotsTable = TableRegistry::get("AssignPlots");

        $commissionsTable = TableRegistry::get("Commissions");

        $payoutsTable = TableRegistry::get("Payouts");

        $conditions = [
            "Users.role_id" => 2,
        ];

        $order = ["Users.username" => "ASC"];

        $join = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $fields = ["Details.id", "Details.first_name", "Details.last_name"];

        $users = $usersTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("users", $users);

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $user_id = isset(
                $this->request->getData()["PlotPayment"]["user_id"]
            )
                ? trim($this->request->getData()["PlotPayment"]["user_id"])
                : "";

            $amount = isset($this->request->getData()["PlotPayment"]["amount"])
                ? trim($this->request->getData()["PlotPayment"]["amount"])
                : "";

            if (!empty($user_id) && !empty($amount)) {
                $join = [
                    [
                        "table" => "details",

                        "alias" => "Details",

                        "type" => "INNER",

                        "conditions" => ["Details.user_id = Users.id"],
                    ],
                ];

                $conditions = [
                    "Users.id" => $user_id,
                ];

                $fields = [
                    "Details.id",
                    "Details.first_name",
                    "Details.last_name",
                    "Details.contact_no",
                ];

                $userData = $usersTable
                    ->find("all", [
                        "fields" => $fields,
                        "conditions" => $conditions,
                        "join" => $join,
                    ])
                    ->enableAutoFields(true)
                    ->first();

                $usersTable->updateParentsOnUpgradeTemp(
                    $user_id,
                    $userData->parent_id,
                    $amount
                );

                $this->Flash->success(
                    __(
                        "Congratulations! Payment has been deleted successfully."
                    )
                );

                return $this->redirect(
                    $this->backend_url .
                        "/projects/plot-payment-list/" .
                        $user_id
                );
            } else {
                $this->Flash->error(__("Please fill all required fields."));
            }
        }
    }

    public function paymentReceipt($encPlotPaymentId)
    {
        $this->viewBuilder()->setLayout('blank');

        /*if(!$this->request->getSession()->check('adminUserId')){

            return $this->redirect($this->backend_url.'/user/login');

        }*/

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Payment Receipt";

        $this->set("title", $title);

        $plotPaymentsTable = TableRegistry::get("PlotPayments");

        $plotPaymentId = base64_decode($encPlotPaymentId);

        $printData = [];

        $join = [
            [
                "table" => "assign_plots",

                "alias" => "AssignPlots",

                "type" => "LEFT",

                "conditions" => [
                    "AssignPlots.id = PlotPayments.assign_plot_id",
                ],
            ],

            [
                "table" => "sites",

                "alias" => "Sites",

                "type" => "LEFT",

                "conditions" => ["Sites.id = AssignPlots.site_id"],
            ],

            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = PlotPayments.user_id"],
            ],

            [
                "table" => "states",

                "alias" => "States",

                "type" => "LEFT",

                "conditions" => ["States.id = Details.state_id"],
            ],

            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = PlotPayments.user_id"],
            ],

            [
                "table" => "users",

                "alias" => "Sponsors",

                "type" => "LEFT",

                "conditions" => ["Sponsors.id = Users.sponsor_id"],
            ],

            [
                "table" => "details",

                "alias" => "SponsorDetails",

                "type" => "LEFT",

                "conditions" => ["SponsorDetails.user_id = Sponsors.id"],
            ],
        ];

        $conditions = [
            "PlotPayments.id" => $plotPaymentId,
        ];

        $fields = [
            "AssignPlots.id",
            "AssignPlots.plot_number",
            "AssignPlots.area",
            "Sites.id",
            "Sites.title",
            "Details.id",
            "Details.first_name",
            "Details.last_name",
            "Details.father_name",
            "Details.contact_no",
            "Details.address",
            "Details.pin_code",
            "Details.city_name",
            "States.id",
            "States.name",
            "SponsorDetails.first_name",
            "SponsorDetails.last_name",
        ];

        $plotPaymentInfo = $plotPaymentsTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
            ])
            ->enableAutoFields(true)
            ->first();

        /*echo '<pre>';

        print_r($plotPaymentInfo);

        exit;*/

        if (!empty($plotPaymentInfo)) {
            /*if($_SERVER['DOCUMENT_ROOT'] == 'E:/xampp/htdocs'){

                require_once($_SERVER['DOCUMENT_ROOT']."/jksinfratech/webroot/fpdf/print_receipt.php");

            }else{

                require_once($_SERVER['DOCUMENT_ROOT']."/webroot/fpdf/print_receipt.php");

            }*/

            $tlName =
                $plotPaymentInfo->SponsorDetails["first_name"] .
                " " .
                $plotPaymentInfo->SponsorDetails["last_name"];

            $address = $plotPaymentInfo->Details["address"];

            if (!empty($plotPaymentInfo->Details["city_name"])) {
                $address =
                    $address . ", " . $plotPaymentInfo->Details["city_name"];
            }

            if (!empty($plotPaymentInfo->Details["pin_code"])) {
                $address =
                    $address . ", " . $plotPaymentInfo->Details["pin_code"];
            }

            if (!empty($plotPaymentInfo->States["name"])) {
                $address = $address . ", " . $plotPaymentInfo->States["name"];
            }

            $printData["payment_date"] = $plotPaymentInfo->created;

            $printData["receipt_no"] = $plotPaymentInfo->id;

            $printData["amount"] = $plotPaymentInfo->amount;

            $printData["amount_in_words"] = $plotPaymentsTable->numberTowords(
                $plotPaymentInfo->amount
            );

            $printData["payment_mode"] = $plotPaymentInfo->payment_mode;

            $printData["plot_number"] = !empty(
                $plotPaymentInfo->AssignPlots["plot_number"]
            )
                ? $plotPaymentInfo->AssignPlots["plot_number"]
                : "N/A";

            $printData["area"] = !empty($plotPaymentInfo->AssignPlots["area"])
                ? $plotPaymentInfo->AssignPlots["area"]
                : "N/A";

            $printData["received_from"] =
                $plotPaymentInfo->Details["first_name"] .
                " " .
                $plotPaymentInfo->Details["last_name"];

            $printData["father_name"] = !empty(
                $plotPaymentInfo->Details["father_name"]
            )
                ? $plotPaymentInfo->Details["father_name"]
                : "N/A";

            $printData["contact_no"] = !empty(
                $plotPaymentInfo->Details["contact_no"]
            )
                ? $plotPaymentInfo->Details["contact_no"]
                : "N/A";

            $printData["address"] = !empty($address) ? $address : "N/A";

            $printData["bank_name"] = !empty($plotPaymentInfo->bank)
                ? $plotPaymentInfo->bank
                : "N/A";

            $printData["site"] = !empty($plotPaymentInfo->Sites["title"])
                ? $plotPaymentInfo->Sites["title"]
                : "N/A";

            $printData["remark"] = "N/A";

            $printData["tlName"] = !empty(trim($tlName))
                ? trim($tlName)
                : "N/A";

            /*echo '<pre>';

            print_r($printData);

            exit;*/

            /*if(!empty($printData)){

                printReceit($printData);

            }*/
        }

        //$this->autoRender = false;

        $this->set("printData", $printData);
    }

    public function plotPaymentList($intUserId = null, $intAssignPlotId = null)
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Plot Payment List";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $plotPaymentsTable = TableRegistry::get("PlotPayments");

        $assignPlotsTable = TableRegistry::get("AssignPlots");

        $conditions = [
            "Users.role_id" => 2,

            //'AssignPlots.status' => 1
        ];

        $order = ["Users.username" => "ASC"];

        $join = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ] /*,

                array(

                    'table' => 'assign_plots',

                    'alias' => 'AssignPlots',

                    'type' => 'INNER',

                    'conditions' => array('AssignPlots.user_id = Users.id')

                )*/,
        ];

        $group = ["Users.id"];

        $fields = ["Details.id", "Details.first_name", "Details.last_name"];

        $users = $usersTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("users", $users);

        $assignPlots = [];

        $plotPayments = [];

        $totalPaymentInfo = [];
        
        $limit = 10;
        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $user_id = isset(
                $this->request->getData()["PlotPayment"]["user_id"]
            )
                ? trim($this->request->getData()["PlotPayment"]["user_id"])
                : "";

            $assign_plot_id = isset(
                $this->request->getData()["PlotPayment"]["assign_plot_id"]
            )
                ? trim(
                    $this->request->getData()["PlotPayment"]["assign_plot_id"]
                )
                : "";

            $from_date =
                isset($this->request->getData()["PlotPayment"]["from_date"]) &&
                !empty($this->request->getData()["PlotPayment"]["from_date"])
                    ? date(
                        "Y-m-d",
                        strtotime(
                            trim(
                                $this->request->getData()["PlotPayment"][
                                    "from_date"
                                ]
                            )
                        )
                    )
                    : "";

            $to_date =
                isset($this->request->getData()["PlotPayment"]["to_date"]) &&
                !empty($this->request->getData()["PlotPayment"]["to_date"])
                    ? date(
                        "Y-m-d",
                        strtotime(
                            trim(
                                $this->request->getData()["PlotPayment"][
                                    "to_date"
                                ]
                            )
                        )
                    )
                    : "";

            $join = [
                [
                    "table" => "plots",

                    "alias" => "Plots",

                    "type" => "INNER",

                    "conditions" => ["Plots.id = AssignPlots.plot_id"],
                ],
            ];

            $conditions = [
                "AssignPlots.user_id" => $user_id,

                "AssignPlots.status" => 1,
            ];

            $order = ["Plots.name" => "ASC"];

            $fields = [
                "AssignPlots.id",
                "AssignPlots.plot_number",
                "Plots.id",
                "Plots.name",
            ];

            $assignPlots = $assignPlotsTable
                ->find("all", [
                    "fields" => $fields,
                    "join" => $join,
                    "conditions" => $conditions,
                    "order" => $order,
                ])
                ->toArray();

            $userFilter = [];

            $plotFilter = [];

            $fromDateFilter = [];

            $toDateFilter = [];

            $join = [
                [
                    "table" => "users",

                    "alias" => "Users",

                    "type" => "INNER",

                    "conditions" => ["Users.id = PlotPayments.user_id"],
                ],

                [
                    "table" => "details",

                    "alias" => "Details",

                    "type" => "INNER",

                    "conditions" => ["Details.user_id = Users.id"],
                ],
            ];

            if (!empty($user_id)) {
                $userFilter = [
                    "PlotPayments.user_id" => $user_id,
                ];
            }

            if (!empty($assign_plot_id)) {
                $plotFilter = [
                    "PlotPayments.assign_plot_id" => $user_id,
                ];
            }

            if (!empty($from_date)) {
                $fromDateFilter = [
                    "DATE(PlotPayments.created) >=" => $from_date,
                ];
            }

            if (!empty($to_date)) {
                $toDateFilter = [
                    "DATE(PlotPayments.created) <=" => $to_date,
                ];
            }

            $conditions = array_merge(
                $userFilter,
                $plotFilter,
                $fromDateFilter,
                $toDateFilter
            );

            $order = [
                "PlotPayments.id" => "DESC",
            ];

            $fields = [
                "Users.id",
                "Users.username",
                "Details.id",
                "Details.first_name",
                "Details.last_name",
            ];

            $plotPayments = $plotPaymentsTable
                ->find("all", [
                    "fields" => $fields,
                    "join" => $join,
                    "conditions" => $conditions,
                    "order" => $order,
                ])
                ->enableAutoFields(true)
                ->toArray();

            $totalPaymentInfo = $plotPaymentsTable
                ->find("all", [
                    "fields" => $fields,
                    "join" => $join,
                    "conditions" => $conditions,
                    "order" => $order,
                ])
                ->select(["total_amount" => "SUM(PlotPayments.amount)"])
                ->first();
        } elseif (!empty($intUserId) && !empty($intAssignPlotId)) {
            $user_id = $intUserId;

            $assign_plot_id = $intAssignPlotId;

            $join = [
                [
                    "table" => "plots",

                    "alias" => "Plots",

                    "type" => "INNER",

                    "conditions" => ["Plots.id = AssignPlots.plot_id"],
                ],
            ];

            $conditions = [
                "AssignPlots.user_id" => $user_id,

                "AssignPlots.status" => 1,
            ];

            $order = ["Plots.name" => "ASC"];

            $fields = [
                "AssignPlots.id",
                "AssignPlots.plot_number",
                "Plots.id",
                "Plots.name",
            ];

            $assignPlots = $assignPlotsTable
                ->find("all", [
                    "fields" => $fields,
                    "join" => $join,
                    "conditions" => $conditions,
                    "order" => $order,
                ])
                ->toArray();

            $join = [
                [
                    "table" => "users",

                    "alias" => "Users",

                    "type" => "INNER",

                    "conditions" => ["Users.id = PlotPayments.user_id"],
                ],

                [
                    "table" => "details",

                    "alias" => "Details",

                    "type" => "INNER",

                    "conditions" => ["Details.user_id = Users.id"],
                ],
            ];

            $conditions = [
                "PlotPayments.user_id" => $user_id,

                "PlotPayments.assign_plot_id" => $assign_plot_id,
            ];

            $order = [
                "PlotPayments.id" => "DESC",
            ];

            $fields = [
                "Users.id",
                "Users.username",
                "Details.id",
                "Details.first_name",
                "Details.last_name",
            ];

            $plotPayments = $plotPaymentsTable
                ->find("all", [
                    "fields" => $fields,
                    "join" => $join,
                    "conditions" => $conditions,
                    "order" => $order,
                ])
                ->select(["total_amount" => "SUM(PlotPayments.amount)"])

                ->enableAutoFields(true)
                ->toArray();

            $totalPaymentInfo = $plotPaymentsTable
                ->find("all", [
                    "fields" => $fields,
                    "join" => $join,
                    "conditions" => $conditions,
                    "order" => $order,
                ])
                ->select(["total_amount" => "SUM(PlotPayments.amount)"])
                ->first();
        } elseif (!empty($intUserId)) {

            $user_id = $intUserId;

            $join = [
                [
                    "table" => "plots",

                    "alias" => "Plots",

                    "type" => "INNER",

                    "conditions" => ["Plots.id = AssignPlots.plot_id"],
                ],
            ];

            $conditions = [
                "AssignPlots.user_id" => $user_id,

                "AssignPlots.status" => 1,
            ];

            $order = ["Plots.name" => "ASC"];

            $fields = [
                "AssignPlots.id",
                "AssignPlots.plot_number",
                "Plots.id",
                "Plots.name",
            ];

            $assignPlots = $assignPlotsTable
                ->find("all", [
                    "fields" => $fields,
                    "join" => $join,
                    "conditions" => $conditions,
                    "order" => $order,
                ])
                ->toArray();

            $join = [
                [
                    "table" => "users",

                    "alias" => "Users",

                    "type" => "INNER",

                    "conditions" => ["Users.id = PlotPayments.user_id"],
                ],

                [
                    "table" => "details",

                    "alias" => "Details",

                    "type" => "INNER",

                    "conditions" => ["Details.user_id = Users.id"],
                ],
            ];

            $conditions = [
                "PlotPayments.user_id" => $user_id,
            ];

            $order = [
                "PlotPayments.id" => "DESC",
            ];

            $fields = [
                "Users.id",
                "Users.username",
                "Details.id",
                "Details.first_name",
                "Details.last_name",
            ];

            $plotPayments = $plotPaymentsTable
                ->find("all", [
                    "fields" => $fields,
                    "join" => $join,
                    "conditions" => $conditions,
                    "order" => $order
                ])
                ->enableAutoFields(true)
                ->toArray();

            $totalPaymentInfo = $plotPaymentsTable
                ->find("all", [
                    "fields" => $fields,
                    "join" => $join,
                    "conditions" => $conditions,
                    "order" => $order,
                ])
                ->select(["total_amount" => "SUM(PlotPayments.amount)"])
                ->first();
        } else {
            $join = [
                [
                    "table" => "users",

                    "alias" => "Users",

                    "type" => "INNER",

                    "conditions" => ["Users.id = PlotPayments.user_id"],
                ],

                [
                    "table" => "details",

                    "alias" => "Details",

                    "type" => "INNER",

                    "conditions" => ["Details.user_id = Users.id"],
                ],
            ];

            $conditions = [];

            $order = [
                "PlotPayments.id" => "DESC",
            ];

            $fields = [
                "Users.id",
                "Users.username",
                "Details.id",
                "Details.first_name",
                "Details.last_name",
            ];

            $plotPayments = $plotPaymentsTable
                ->find("all", [
                    "fields" => $fields,
                    "join" => $join,
                    "conditions" => $conditions,
                    "order" => $order
                ])
                ->enableAutoFields(true)
                ->toArray();

            $totalPaymentInfo = $plotPaymentsTable
                ->find("all", [
                    "fields" => $fields,
                    "join" => $join,
                    "conditions" => $conditions,
                    "order" => $order,
                ])
                ->select(["total_amount" => "SUM(PlotPayments.amount)"])
                ->first();
            
        }

        $this->set("assignPlots", $assignPlots);

        $this->set("plotPayments", $plotPayments);

        $this->set("totalPaymentInfo", $totalPaymentInfo);

        $this->set("intUserId", $intUserId);

        $this->set("intAssignPlotId", $intAssignPlotId);
    }

    public function changePlotStatus($encStatus, $encPlotId)
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Change Plot Status";

        $this->set("title", $title);

        $plotsTable = TableRegistry::get("Plots");

        if (empty($encStatus) || empty($encStatus)) {
            return $this->redirect($this->backend_url . "/projects/plots");
        }

        $intId = base64_decode($encPlotId);

        $status = base64_decode($encStatus);

        $plotData = $plotsTable->get($intId);

        $plotData->status = $status;

        $plotData->remark = isset($this->request->getData()["Plot"]["remark"])
            ? trim($this->request->getData()["Plot"]["remark"])
            : "";

        if ($plotsTable->save($plotData)) {
            $this->Flash->success(
                __(
                    "Congratulations! Plot status has been changed successfully."
                )
            );

            return $this->redirect($this->backend_url . "/projects/plots");
        }

        $this->autoRender = false;
    }

    public function deletePayment($encPlotPaymentId)
    {
        $this->viewBuilder()->setLayout(false);

        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Payment Receipt";

        $this->set("title", $title);

        $plotPaymentsTable = TableRegistry::get("PlotPayments");

        $usersTable = TableRegistry::get("Users");

        $payoutsTable = TableRegistry::get("Payouts");

        $plotPaymentId = base64_decode($encPlotPaymentId);

        $conditions = [
            "PlotPayments.id" => $plotPaymentId,
        ];

        $plotPaymentInfo = $plotPaymentsTable
            ->find("all", ["conditions" => $conditions])
            ->first();

        if (!empty($plotPaymentInfo)) {
            $user_id = $plotPaymentInfo->user_id;

            $amount = $plotPaymentInfo->amount;

            $join = [
                [
                    "table" => "details",

                    "alias" => "Details",

                    "type" => "INNER",

                    "conditions" => ["Details.user_id = Users.id"],
                ],
            ];

            $conditions = [
                "Users.id" => $plotPaymentInfo->user_id,
            ];

            $fields = [
                "Details.id",
                "Details.first_name",
                "Details.last_name",
                "Details.contact_no",
            ];

            $userData = $usersTable
                ->find("all", [
                    "fields" => $fields,
                    "conditions" => $conditions,
                    "join" => $join,
                ])
                ->enableAutoFields(true)
                ->first();

            if (isset($userData->sponsor_id) && !empty($userData->sponsor_id)) {
                //echo 'sadas';exit;

                $sponsorInfo = $usersTable
                    ->find("all", [
                        "conditions" => ["Users.id" => $userData->sponsor_id],
                    ])
                    ->enableAutoFields(true)
                    ->first();

                $sponsor = $usersTable->get($userData->sponsor_id);

                if ($userData->position == "left") {
                    $sponsor->total_direct_acitve_left =
                        $sponsorInfo->total_direct_acitve_left - $amount;
                } else {
                    $sponsor->total_direct_acitve_right =
                        $sponsorInfo->total_direct_acitve_right - $amount;
                }

                $usersTable->save($sponsor);

                $directAmount = ($amount * 11) / 100;

                $payout = $payoutsTable->newEmptyEntity();

                $payout->upgraded_table_id = $user_id;

                $payout->upagraded_user_id = $userData->sponsor_id;

                $payout->direct_amount = "-" . $directAmount;

                $payout->tax = isset($commission->tax) ? $commission->tax : 0;

                $payout->admin_commission = isset($commission->amount)
                    ? $commission->amount
                    : 0;

                $payoutsTable->save($payout);
            }

            $usersTable->removeFromDownlines($user_id, $amount);

            $usersTable->updateParentsOnDegrade(
                $user_id,
                $userData->parent_id,
                $amount
            );

            $plotPaymentsTable->deleteAll(["id" => $plotPaymentId]);
        }

        $this->Flash->success(__("Payment has been removed successfully."));

        return $this->redirect(
            $this->backend_url . "/projects/plot-payment-list"
        );

        $this->autoRender = false;
    }

    public function assignedUnitList()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Assigned Unit List";

        $this->set("title", $title);

        $plotPaymentsTable = TableRegistry::get("PlotPayments");

        $join = [
            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = PlotPayments.user_id"],
            ],

            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $conditions = [
            "PlotPayments.number_of_unit >= " => 0,
        ];

        $order = [
            "PlotPayments.id" => "DESC",
        ];

        $fields = [
            "Users.id",
            "Users.username",
            "Details.id",
            "Details.first_name",
            "Details.last_name",
        ];

        $plotPayments = $plotPaymentsTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("plotPayments", $plotPayments);
    }

    public function editUnit($encPlotPaymentId)
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url . "/user/login");
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Payment Receipt";

        $this->set("title", $title);

        $plotPaymentsTable = TableRegistry::get("PlotPayments");

        $usersTable = TableRegistry::get("Users");

        $payoutsTable = TableRegistry::get("Payouts");

        $plotPaymentId = base64_decode($encPlotPaymentId);

        $join = [
            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = PlotPayments.user_id"],
            ],

            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $conditions = [
            "PlotPayments.id" => $plotPaymentId,
        ];

        $fields = [
            "Users.id",
            "Users.username",
            "Details.id",
            "Details.first_name",
            "Details.last_name",
        ];

        $plotPaymentInfo = $plotPaymentsTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "join" => $join,
            ])
            ->enableAutoFields(true)
            ->first();

        if (empty($plotPaymentInfo)) {
            return $this->redirect(
                $this->backend_url . "/projects/assigned-unit-list"
            );
        }

        $this->set("plotPaymentInfo", $plotPaymentInfo);

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $number_of_unit = isset(
                $this->request->getData()["PlotPayment"]["number_of_unit"]
            )
                ? $this->request->getData()["PlotPayment"]["number_of_unit"]
                : "";

            if (!empty($number_of_unit)) {
                $plotPaymentData = $plotPaymentsTable->get($plotPaymentId);

                $plotPaymentData->number_of_unit = $number_of_unit;

                $plotPaymentsTable->save($plotPaymentData);

                $this->Flash->success(
                    __(
                        "Congratulations! Assigned Unit has been changed successfully."
                    )
                );

                return $this->redirect(
                    $this->backend_url . "/projects/assigned-unit-list"
                );
            } else {
                $this->Flash->error(__("Please fill all required fields."));
            }
        }
    }
}
