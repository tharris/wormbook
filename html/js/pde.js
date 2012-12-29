/*
	PureDOM explorer
	written by Christian Heilmann (http://icant.co.uk)
	Please refer to the pde homepage for updates: http://www.onlinetools.org/tools/puredom/
	Free for non-commercial use. Changes welcome, but no distribution without 
	the consent of the author.
*/
function pde_init()
{

/* CSS class names, change if needed */
	var mp='pde_nav';
	var hp='pde_hide';
	var sp='pde_show';
	var pp='pde_parent';
	var pa='pde_active';
	var cu='current';
	
	var d,uls,i;
	if(!document.getElementById && !document.createTextNode){return;}

/* navigation ID, change if needed */
	d=document.getElementById('nav');

	if (!d){return;}
	pde_addclass(d,mp)
	uls=d.getElementsByTagName('ul');
	for (i=0;i<uls.length;i++)
	{
		if(pde_checkcurrent(uls[i]))
		{
			pde_addclass(uls[i].parentNode.firstChild,pa);
		} else {
			pde_addclass(uls[i],hp);
			pde_addclass(uls[i].parentNode.firstChild,pp);
			uls[i].parentNode.firstChild.onclick=function()
			{
				pde_swapclass(this,pp,pa);
				pde_swapclass(this.parentNode.getElementsByTagName('ul')[0],hp,sp);
				return false;
			}
		}
	}
	function pde_checkcurrent(o){
		if(pde_check(o.parentNode,cu)){return true;}
		for(var i=0;i<o.getElementsByTagName('li').length;i++)
		{
			if(pde_check(o.getElementsByTagName('li')[i],cu)){return true;}
		}
		return false;
	}
	function pde_swapclass(o,c1,c2)
	{
		var cn=o.className
		o.className=!pde_check(o,c1)?cn.replace(c2,c1):cn.replace(c1,c2);
	}
	function pde_addclass(o,c)
	{
		if(!pde_check(o,c)){o.className+=o.className==''?c:' '+c;}
	}
	function pde_check(o,c)
	{
	 	return new RegExp('\\b'+c+'\\b').test(o.className);
	}
}
window.onload=function(){
	pde_init();
	// add other functions here.
}
