<?php

//:show the content of a specific file from a GitHub repository
//:[[git_get_file_content?user=phpManufaktur&repository=libGitHubAPI&file=README.md]]

if (file_exists(WB_PATH.'/modules/lib_githubapi/library/Github/Autoloader.php')) {
  require_once WB_PATH.'/modules/lib_githubapi/wb2lepton.php';
  require_once LEPTON_PATH.'/modules/lib_githubapi/library/Github/Autoloader.php';
}
else {
  return "libGitHubAPI is not installed!";
}

Github_Autoloader::register();
$github = new Github_Client();

$result = '';

if (!isset($user) || !isset($repository) || !isset($file)) {
  return "Please use the parameters 'user', 'repository' and 'file_name'!";
}

$repo = $github->getRepoApi()->getRepoBranches($user, $repository);
if (isset($repo['master'])) {
  $sha_master = $repo['master'];
  $result = $github->getObjectApi()->showBlob($user, $repository, $sha_master, $file);
  $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
  if (file_exists(LEPTON_PATH.'/modules/lib_markdown/standard/markdown.php')) {
    require_once(LEPTON_PATH.'/modules/lib_markdown/standard/markdown.php');
    $result = Markdown($result['data']);
  }
  else {
    $result = sprintf('div class="github_file_content">%s</div>', $result['data']);
  }
}
else {
  // no SHA for the master tree
  $result = 'Error: Got no SHA value for the master tree!';
}

return $result;