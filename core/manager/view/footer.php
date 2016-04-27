<?php
if ($groupid) {
$server ['year'] = date ( 'Y', time () );
print <<<EOT

 <div class="footer">2010-$server[year] &copy; <a href="{$constant['SYS_WEBSITE']}" target="_blank">{$constant['SYS_NAME']}</a> V {$constant['SYS_VERSION']} BUILD {$constant['SYS_RELEASE']}</div>
</div>
</body>
</html>
EOT;
}