# Safety Data Sheet search

Type in a molecule name in the search box, hit Enter, and the tool will help find the SDS sheet for the compound from Sigma-Aldrich!

Try out a molecule from the following link. A lot of them will be commercially available: https://www.acs.org/content/acs/en/molecule-of-the-week/archive.html?archive=All

Built with PHP 8.1.2 and Nginx

## Preview

![image](https://user-images.githubusercontent.com/88711401/184509171-f8a1c73a-b540-4c99-b874-4fed4d3b3252.png)

**Improvements to be made**

* Only searches Sigma-Aldrich for SDS sheets, won't return anything if not in their catalogue. Maybe include other manufacturers
* Improve searching method to include CAS no. so that it's more definite
* Remove tabs from front page, improve general design
* Add validation (no blank field)
