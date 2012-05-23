<?php

//:show the issues for a specific GitHub repository
//:[[git_get_issues?user=phpManufaktur&repository=libGitHubAPI]]

if (file_exists(WB_PATH.'/modules/lib_githubapi/library/Github/Autoloader.php')) {
  require_once WB_PATH.'/modules/lib_githubapi/wb2lepton.php';
  require_once LEPTON_PATH.'/modules/lib_githubapi/library/Github/Autoloader.php';
  $use_markdown = false;
  if (file_exists(LEPTON_PATH.'/modules/lib_markdown/standard/markdown.php')) {
    require_once(LEPTON_PATH.'/modules/lib_markdown/standard/markdown.php');
    $use_markdown = true;
  }
}
else {
  return "libGitHubAPI is not installed!";
}

Github_Autoloader::register();
$github = new Github_Client();

$result = '';

if (!isset($user) || !isset($repository)) {
  return "Please use the parameters 'user' and 'repository'!";
}
$issue_mode = (isset($mode) && (strtolower($mode) == 'closed')) ? 'closed' : 'open';
$issue_count = (isset($count)) ? (int) $count : 3;
$gravatar_size = (isset($gravatar)) ? (int) $gravatar : 80;

$issues = $github->getIssueApi()->getList($user, $repository, $issue_mode);
// sort array revert but keep keys
krsort($issues);

$i=0;
foreach ($issues as $issue) {
  $i++;
  if ($i > $issue_count) break;
  $result .= sprintf(
      '<div class="git_issue_item">'.
        '<div class="git_issue_avatar"><img src="http://www.gravatar.com/avatar/%s?d=mm&s=%d" width="%d" height="%d" alt="%s" /></div>'.
        '<div class="git_issue_content">'.
          '<div class="git_issue_id"><a href="%s" target="_blank">Ticket #%d</a> - <span class="git_issue_title">%s</span></div>'.
          '<div class="git_issue_date">%s - <a href="https://github.com/%s" target="_blank">%s</a></div>'.
          '<div class="git_issue_body">%s</div>'.
          '%s'.
        '</div>'.
      '</div>',
      $issue['gravatar_id'],
      $gravatar_size,
      $gravatar_size,
      $gravatar_size,
      $issue['user'],
      $issue['html_url'],
      $issue['number'],
      $issue['title'],
      date('d.m.Y', strtotime($issue['created_at'])),
      $issue['user'],
      $issue['user'],
      $use_markdown ? Markdown($issue['body']) : $issue['body'],
      $issue['comments'] > 0 ? sprintf('<div class="git_issue_comments"><a href="%s" target="_blank">Zu diesem Ticket gibt es %d Kommentare</a></div>', $issue['html_url'], $issue['comments']) : ''
      );
}
if (empty($result)) {
  $result = '<div class="git_issue_container">- es liegen z.Zt. keine unbearbeiteten Fehlermeldungen vor -</div>';
}
else {
  $result = sprintf('<div class="git_issue_container">%s<div style="clear:both;"></div></div>', $result);
}

return $result;
