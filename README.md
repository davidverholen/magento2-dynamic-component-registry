# Dynamic Component Registry

The Idea behind this module is to make it more easy to develop Magento2 Modules. Instead of Symlinking the Module into the Magento2 app/code directory, the Component Registrar is utilized to register a dynamic Path for a Component.

### How To Use

- In the Magento Backend go to System -> Dynamic Components
- Add a new Component
- The Name has to Match the configured Component Name (For a Module this is defined in the etc/module.xml
- The path has to be relative to the Magento2 root directory
- The Namespace prefix must have a trailing slash and must not have a leading slash
- After saving the component you might have to execute bin/magento setup:upgrade or bin/magento module:enable Vendor_Module (or disable)

### Example
- Name: Vendor_Module
- Path: ../../myModules/ModuleDir
- PSR-4 Prefix: Vendor\ModuleName\
