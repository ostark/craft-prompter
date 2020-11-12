
# Prompter Structure

## Repositories

* entries https://craftcms.com/docs/3.x/entries.html#querying-entries
* assets https://craftcms.com/docs/3.x/assets.html#querying-assets
* categories https://craftcms.com/docs/3.x/categories.html#querying-categories
* globalSets https://craftcms.com/docs/3.x/globals.html#querying-globals

* matrixBlocks https://craftcms.com/docs/3.x/matrix-blocks.html#querying-matrix-blocks
* (tags) https://craftcms.com/docs/3.x/tags.html#querying-tags
* (users) https://craftcms.com/docs/3.x/users.html#querying-users

## Actions

* prompter/make (generate files)
* prompter/help

## stubs

* class.stub (generic class)
* extension.class.stub (twig extension class)
* phpstorm.meta.stub (phpstorm overwrites)
* variable.class.stub (craft variable class)

## Setting

* twig bool (generate fake twig extension | default:true)
* twigVariables[]  (a map of names and the classes - I should be able to read those)
* twigCraftVariableBehaviors[] (I should be able to read those)
* elements bool (generate fake models for all kind of elements | default:true)
* phpstormMeta bool (default:true)
* generateOnChange (default:false)
* classPrefix string|null (A prefix to avoid collisions, default `Prompter` or null?)


# Nice to have

* add generated files to gitignore
* publish default config `afterInstall`
* queue execution if triggered onChange
