const { exec } = require('child_process');
const { format } = require('util');

function run(cmd) {

  const formatted = format('vendor/bin/wp %s', cmd);

  exec(formatted, (err, stdout, stderr) => {
    console.info(`> wp ${cmd}`);
    if (err) {
      console.error(stderr);
    }

    console.info(stdout);
  });
}

// Delete default stuff
run('post delete 1 --force');
run('post delete 2 --force');

run('post create --post_status="publish" --post_type="page" --post_title="Home" --post_content="Hello world" ');
run('post create --post_status="publish" --post_type="page" --post_title="About" --post_content="Hello world" ');
