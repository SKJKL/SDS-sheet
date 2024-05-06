# Safety Data Sheet search

A simple site to help with risk assessments!

Type in a molecule name in the search box, hit Enter, and the tool will help find the SDS sheet for the compound from Sigma-Aldrich.

The site will scrape the PDF and extract the important information used to draft risk assessments.

Try out a molecule from the following link. A lot of them will be commercially available: https://www.acs.org/content/acs/en/molecule-of-the-week/archive.html?archive=All

Built with PHP 8.1.2 and Nginx

## Preview

![image](/docs/Home.png)
![image](/docs/Results.png)

**Improvements to be made**

* Only searches Sigma-Aldrich for SDS sheets
* Improve searching method to include CAS no. so that it's more definite
