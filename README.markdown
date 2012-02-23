##### Scrape engine structure

The scraping information are obtained by running the scrape.php controller with the corresponding course code and course number. The course information result will be scraped, and the information is stored inside of a tree structure (i.e. array of arrays) shown by the following diagram.

![Tree Struture](https://github.com/Concordia-Pasta/Pasta-Project/raw/master/assets/img/readme/tree-struct.png)

When the scraping function is called, it can be passed as an argument directly to the view page, in which every key will become a valid variable which can be displayed. __Remember that you do not need to call `$data`__. You use the key directly as the variable to echo, e.g. `$session`, or `$prerequisite`. 

For example, if you have scraped for COMP 248, then the title of the course to display in the view file is simply:
	$title
The course number and course code to echo in html is
	<?php echo "$code $number"; ?>

You could list all the section as an array with
	print_r($session);

To get to a lecture professor
	echo $session['D']['professor'];
	
##### Prerequisite Structure
The prerequisite structure is also an array containing the information of the prerequisite for a particular course.
To print the prerequisite course, simply call
	print_r($prerequisite);
in your view file.

The prerequisite has multiple array, in general, if a sub array has only 1 element, then it is a prerequisite. Else if a sub array has multiple element, e.g. 2 or more, then it means that any of the course in this sub array is considered as a valid prerequisite.

For example:
	COMP 352; COMP 345; MATH 203 or MATH 232;

Then
	echo $prerequisite[0][0]['code']; => COMP
	echo $prerequisite[0][0]['number']; => 352
	
	echo $prerequisite[1][0]['code']; => COMP
	echo $prerequisite[1][0]['number']; => 345
		
	echo $prerequisite[2][0]['code']; => MATH
	echo $prerequisite[2][0]['number']; => 203
	
	echo $prerequisite[2][1]['code']; => MATH
	echo $prerequisite[2][1]['number']; => 232
	
This structure is quite redundant, but I think it will serve our purpose for now, if there is more modification to be made or simplification to be made, then it can be done as well.

##### Announcement

- Removed the TEST branch, use only develop and master. Three branches seems to be hard to managed.
- Sorry I was toying with the commits and messed up the commit histroy - Charles.

##### Basic Workflow
- master branch should contains our most stable releases.
- develop branch should contains our infinished testing code. It is your duty to insure that whatever code your adding, that piece of code should be compatible with the rest of the other codes.
- topic branch(es) should be only created on your __local__ machine. Merge your final code into `develop` branch first, and then `push` it to the `develop` branch so other people can see it, test it, or modify it.

# Hi Welcome to Pasta
#### The online Concordia software engineer schedule marker for the year of 2011/2012

# Our Team
	
	Saud Khalid Musafer (saudkm)
	Steven Gourgue
	Eric Rideough (eride) [edited!]
	Bobby Yit
	Charles Chao Yang (snwfog)
	Wais Kedri (waisk)
	Duc Hoang Michel Pham
	Walter Chacon

# Commit Messaging Guideline

First line: Summary of what you did. Do not use past-tense, use only present tense, ie. Upload instead of Uploaded, Add instead of Added, etc.

Second line: Space

Third line and plus: The detail message of your commit.

Please make sure that the commit message body and subject should not be wider than 80 characters wide. Its just a convention.

# Code Styling Standard
http://framework.zend.com/manual/en/coding-standard.coding-style.html
