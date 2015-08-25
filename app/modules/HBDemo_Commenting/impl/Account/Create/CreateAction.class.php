<?php

use Honeybee\FrameworkBinding\Agavi\App\ActionPack\Create\CreateAction;

class HBDemo_Commenting_Account_CreateAction extends CreateAction
{
    public function executeWrite(AgaviRequestDataHolder $request_data)
    {
        /*
            This is how you might wish to implement a console action
            $create_command = $request_data->getParameter('command');
            $this->dispatchCommand($create_command);
            $this->setAttribute('command', $create_command);

            return 'Success';
        */

        $this->setAttribute('resource_type', $this->getResourceType());

        return 'Success';
    }
}
