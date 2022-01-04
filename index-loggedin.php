echo '<div class="menubox">';
echo '    <ul>';
echo '        <li><a href="/">Mit hogyan?</a></li>';
echo '        <li><a href="/?goto=people">Személyek</a></li>';
echo '        <li><a href="/?goto=gallery">Galéria</a></li>';
echo '    </ul>';
echo '</div>';

echo '<div class="container">';

echo '     <div class="container-bal">';
if ($goto == "people")
    {include 'content-people-list.php';}
elseif ($goto == "gallery")
    {include 'content-gallery-list.php';}
else
    {include 'content-mithogyan-bal.php';}
echo '    </div>';

echo '    <div class="container-jobb">';
if ($goto == "people")
    {//include 'content-people-deteails.php';
    }
elseif ($goto == "gallery")
    {include 'content-gallery-deteails.php';}
else
    {include 'content-mithogyan-jobb.php';}
echo '    </div>';

echo '</div>';