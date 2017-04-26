<link rel="stylesheet" href="http://foundation.zurb.com/docs/assets/docs.css" />
<a href="#" data-dropdown="drop3" class="button alert round dropdown"><?php echo "SESSION['id']" ?></a><br>
    <ul id="drop3" data-dropdown-content class="f-dropdown">
      <li><a href="#">Their Name</a></li>
      <li><a href="#">Their detail1</a></li>
      <li><a href="#">Their Detail2</a></li>
   </ul>
   
<script>
  document.write('<script src="http://foundation.zurb.com/docs/assets/vendor/'
    + ('__proto__' in {} ? 'zepto' : 'jquery')
    + '.js"><\/script>');
</script>
   
<script src="http://foundation.zurb.com/docs/assets/docs.js"></script>
<script>
 $(document)
   .foundation();   
</script>

