&lt;?php
//logout.php
require_once 'includes/global.inc.php';

$userTools = new UserTools();
$userTools-&gt;logout();

header("Location: index.php");

?&gt;