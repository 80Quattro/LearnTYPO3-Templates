# typo3

A single installation of TYPO3 can host multiple websites each with its own content

Manage extensions by composer

/typo3 - login page

User permisions and group permissions

# Fluid templates engine

Generate basic SitePackage: [https://www.sitepackagebuilder.com/](https://www.sitepackagebuilder.com/)

Great SitePackage tutorial: [https://www.youtube.com/watch?v=e6v17p-X2WQ&list=PLUxFY3H2SU4iZpoSocMXOT424aiiMGEOQ](https://www.youtube.com/playlist?list=PLUxFY3H2SU4iZpoSocMXOT424aiiMGEOQ)

### Table of contents:
- [Fluid templates engine](#fluid-templates-engine)
  * [Useful fluid commands](#useful-fluid-commands)
    + [Debug](#debug)
    + [For-each loop](#for-each-loop)
    + [if - else condition](#if---else-condition)
    + [Comment](#comment)
    + [Layout Name](#layout-name)
    + [Section Name](#section-name)
    + [Render Partial](#render-partial)
    + [Render Section](#render-section)
    + [Render dynamic content](#render-dynamic-content)
  * [Typo3/Fluid SitePackage structure](#typo3-fluid-sitepackage-structure)
    + [Layouts](#layouts)
    + [Templates](#templates)
    + [Partials](#partials)
  * [Instructions](#instructions)
    + [Include CSS and JS files](#include-css-and-js-files)
    + [Menu](#menu)
    + [Backend Layouts](#backend-layouts)
    + [Dynamic content](#dynamic-content)
  * [Create new template](#create-new-template)

## Useful fluid commands

### Debug

```jsx
<f:debug>{variable}</f:debug>
```

### For-each loop

```jsx
<f:for each={array} as={element} iteration="i">{element}</f:for>
```

### if - else condition

```jsx
<f:if condition={variable}>
	<f:then></f:then>
	<f:else></f:else>
</f:if>
```

### Comment

```jsx
<f:comment>some text / markups</f:comment>
```

### Layout Name

```jsx
<f:layout name="Default" />
```

### Section Name

```jsx
<f:section name="Main" />
```

### Render Partial

Options: `arguments=”{_all}”` or pass specific variable `arguments=”{mainnavigation:mainnavigation}”`

```jsx
<f:render partial="FileNameWithoutExt" arguments="{_all}" />
```

### Render Section

```jsx
<f:render section="FileNameWithoutExt" />
```

### Render dynamic content

```jsx
<f:cObject typoscriptObjectPath="lib.footerLinks" />
```

---

## Typo3/Fluid SitePackage structure

### Layouts

Usually one on the etire webpage. It contains the main elements that are the same on every page.

source: `mysitepackage\Resources\Private\Layouts\Page`

Render template in layout:

```jsx
<f:render section="Main" />
```

### Templates

Each subpage can have its own template (ex. with a side menu, three columns, etc.). Contains the content of the website.

source: `mysitepackage\Resources\Private\Layouts\Page`

```jsx
<f:layout name="Default" />
<f:section name="Main">

</f:section>
```

### Partials

Small piece of layout that can be reusable. Ex. Header and Footer.

source: `mysitepackage\Resources\Private\Partials\Page`

Render Partial in Layout: [(more)](https://www.notion.so/typo3-d0d11e155f6745b89503009d16882995)

```jsx
<f:render partial="FileNameWithoutExt" arguments="{_all}" />
```

---

## Instructions

### Include CSS and JS files

file `/Configuration/TypoScript/setup.typoscript` in object `page{}`.

If we’re loading libraries from external source, we should add `.external = 1` parameter.

```jsx
includeCSS {
	bootstrap = https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css
  bootstrap.external = 1
	style = EXT:car_workshop_sitepackage/Resources/Public/Css/style.css
}

includeJSFooterlibs {
  jquery = https://code.jquery.com/jquery-3.5.1.slim.min.js
  jquery.external = 1
}
```

### Menu

1. Include MenuProcessor in `setup.typoscript` file.
    
    `as = mainnavigation` is important - it’s a name of the variable, which will be available in fluid.
    
    ```jsx
    page {
    	...
    	10 {
    		dataProcessing {
    			...
    			20 = TYPO3\CMS\Frontend\DataProcessing\MenuProcessor
          20 {
    	      levels = 2
            includeSpacer = 1
    				as = mainnavigation
          }
    		}
    	}
    }
    ```
    
2. Implement menu in template.
    1. Simple - 1-level menu
        
        ```jsx
        <ul>
          <f:for each="{mainnavigation}" as="mainnavigationItem">
            <li class="{f:if(condition: mainnavigationItem.active, then:'active')}">
              <a href="{mainnavigationItem.link}" target="{mainnavigationItem.target}" title="{mainnavigationItem.title}">
                  {mainnavigationItem.title}
              </a>
        	  </li>
          </f:for>
        </ul>
        ```
        
    2. 2-level menu
        
        ```jsx
        <ul>
          <f:for each="{mainnavigation}" as="mainnavigationItem">
            <li class="{f:if(condition: mainnavigationItem.active, then:'active')}">
              <a href="{mainnavigationItem.link}" target="{mainnavigationItem.target}" title="{mainnavigationItem.title}">
                  {mainnavigationItem.title}
              </a>
              <f:if condition="{mainnavigationItem.children}">
                <ul>
                  <f:for each="{mainnavigationItem.children}" as="child">
                    <li class="{f:if(condition: child.active, then:'active')}">
                      <a href="{child.link}" target="{child.target}" title="{child.title}">
                        {child.title}
                      </a>
                    </li>
                  </f:for>
        	      </ul>
        	    </f:if>
        	  </li>
          </f:for>
        </ul>
        ```
        
    
    <aside>
    💡 Tipp: 
    Create <a> with link to page with specified id.
    
    ```jsx
    <f:link.page pageUid="1">Home</f:link.page>
    ```
    
    </aside>
    

### Backend Layouts

1. Backend layout can be easily generated by Backend Layout configurator in Backend.
    
    `List > Create new record > Backend Layout` we can setup layout manually in grafic configurator and config script is automatically generated below. This script is interesting for us.
    
2. Create new Layout configuration file (`.tsconfig`) in: `my_site_package\Configuration\TsConfig\Page\Mod\WebLayout\BackendLayouts` and paste config script to it.
3. Be sure that `\Configuration\TsConfig\Page\Mod\WebLayout\BackendLayouts.tsconfig` file loads all Layouts from `\BackendLayouts` folder, not only the default one.
    
    Now new Backend Layout should be visible in TYPO3 backend.
    
4. Go to `Page > Edit page properties > Appearance` and select Backend Layout.
5. Create Template file in `\Templates\Page\` directory. Filename has to be same as name in backend layout .tsconfig file.
    
    ```jsx
    mod.web_layout.BackendLayouts {
      HomePage {
        title = Home Page
    		...
    	}
    }
    ```
    

### Dynamic content

- **Pages**
    
    Add variables field with content in `\Configuration\TypoScript\setup.typoscript`.
    
    ```jsx
    page {
    	...
    	10 {
    		variables {
    	    content0 < styles.content.get
          
    			content1 < styles.content.get
          content1.select.where = colPos = 1
    
          content2 < styles.content.get
          content2.select.where = colPos = 2
    			...
        }
    	}
    }
    ```
    
    Generate dynamic content in specified template.
    
    ```jsx
    <f:format.raw>{content0}</f:format.raw>
    ```
    
- **Special elements / Partials**
    
    Add variables with content in `\Configuration\TypoScript\setup.typoscript` (ex. at the bottom).
    
    ```jsx
    lib.footer < styles.content.get
    lib.footer.select.pidInList = 5
    
    lib.footerBottom < styles.content.get
    lib.footerBottom.select.pidInList = 5
    lib.footerBottom.select.where = colPos = 1
    ```
    
    Generate dynamic content in specified template.
    
    ```jsx
    <f:cObject typoscriptObjectPath="lib.footer" />
    ```
    

---

## Create new template

1. Create new folder `local_packages` in the root directory
2. Generate basic site package (template) at [https://www.sitepackagebuilder.com/](https://www.sitepackagebuilder.com/)
3. In `composer.json` file located in root directory, add `local_packages` folder to repositories to search by composer.
    
    ```javascript
    {
    	"name": "typo3/cms-base-distribution",
    	"description" : "TYPO3 CMS Base Distribution",
    	"license": "GPL-2.0-or-later",
    	"repositories": [
    		{
    			"type": "path",
    			"url": "./local_packages/*"
    		}
    	],
    ...
    ```
    
4. Require extension by composer
    
    ```bash
    ddev composer require name/package_name:@dev
    ```
    
5. Activate template in backgroud
    
    In `Template > Edit whole template record > General` clean up the Setup section.
    
    Go to `Includes` and in `Include static` section select:
    
    > Fluid Content Elements<br>
    Fluid Content Elements CSS<br>
    Your package
    >
