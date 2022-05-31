# Codeigniter-4-CRUD-generator
ADEL CCG is an easy open-source intuitive web app to create AdminLTE4 -Bootstrap 5- dashboards with CRUD operations in php.
The CRUD application is able to manage data from any MySQL database, however complex the structure and volume of data are.
It ships with powerful API, Controller, Model, View generator to speed up the development of your CMS, CRM or other back-office system. 

# Upgrades: Fix & Features
## Core
- Integrated with AdminLTE4 -Bootstrap 5- (https://github.com/MGatner/adminlte4)
- add Unique, minlength Validation 
- use CodeIgniter multi-Language (please read readme.txt in  '/downloads/template.zip')
- add minlength in genertor page, remove maxlength (defined by database)
- auto selected input type 'Date' if table field is date, time, timestamp, year
- auto insert Default Crud-name & Crud-Title after 'Select Table'
- disable 'CRUD language'

## View
- Integrated with AdminLTE4 -Bootstrap 5- (https://github.com/MGatner/adminlte4)
- Support RTL (use  dir="rtl" lang="ar" + adminlte.rtl.min.css in Views\layout\header.php) 
- Support Dark mode (Replace light by dark in classes in Views\layout\master.php + Views\layout\navbar.php + Views\layout\sidebar.php ) 
- use single modal dialog for Add & Edit. for fixed 'dom duplicate error'
- use layout template. copy layout folder to 'App/Views'
- replace function add() & edit() with function save()
- add input 'unique' type validate,
- add class 'invalid-feedback' for response.error-message (not have in old code)
- edit alert popup
- fixed (edit, delete button) language text

## Controller
- New Style Action Button (edit, delete button) : var $ops in function getAll() 
- fixed (edit, delete button) language text

## Next Features!
- add Action 'copy' for clone data

# Install
1. extract template-bs5.zip in 'downloads'
2. copy layout folder to '{youProject}/App/Views/'
3. if you want make empty view. looking viewtemplate.php in 'example'
4. If you want to change the default site language
- copy any folder in 'Language' to '{youProject}/App/Language/'
- change the language code $defaultLocale in 'App/Config/App.php' (en','ar','th')
- Lean Ci4 Localization in [Ci4 Docs](https://codeigniter4.github.io/userguide/outgoing/localization.html)

Youtube video:

[![IMAGE ALT TEXT](https://i.imgur.com/ByT3TEN.png)](https://www.youtube.com/watch?v=Oge6rGn8FpI "ADEL Codeigniter 4 CRUD generator")

SS:

![alt text](https://i.imgur.com/6eQOlV9.png)

![alt text](https://i.imgur.com/Jb3gxs2.png)

![alt text](https://i.imgur.com/ppuMReh.png)

CI forum thread:

https://forum.codeigniter.com/thread-77877.html



---

