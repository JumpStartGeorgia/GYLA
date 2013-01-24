<?php

function is_empty ($path)
{
  if (!is_readable($dir))
  {
    return NULL;
  }
  return (count(scandir($dir)) == 2);
}

function delete ($path)
{
  if (is_dir($path))
  {
    if (is_empty($path))
    {
      rmdir($path);
    }
    else
    {
      if (substr($path, strlen($path) - 1, 1) != '/')
      {
        $path .= '/';
      }
      foreach (glob($path . '*') as $p)
      {
        delete($p);
      }
      rmdir($path);
    }
  }
  elseif (is_file($path))
  {
    unlink($path);
  }
  else
  {
    return;
  }
}
