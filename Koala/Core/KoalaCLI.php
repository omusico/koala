<?php

class KoalaCLI {

	public static $wait_msg = 'Press any key to continue...';

	protected static $foreground_colors = array(
		'black'        => '0;30',
		'dark_gray'    => '1;30',
		'blue'         => '0;34',
		'light_blue'   => '1;34',
		'green'        => '0;32',
		'light_green'  => '1;32',
		'cyan'         => '0;36',
		'light_cyan'   => '1;36',
		'red'          => '0;31',
		'light_red'    => '1;31',
		'purple'       => '0;35',
		'light_purple' => '1;35',
		'brown'        => '0;33',
		'yellow'       => '1;33',
		'light_gray'   => '0;37',
		'white'        => '1;37',
	);
	protected static $background_colors = array(
		'black'      => '40',
		'red'        => '41',
		'green'      => '42',
		'yellow'     => '43',
		'blue'       => '44',
		'magenta'    => '45',
		'cyan'       => '46',
		'light_gray' => '47',
	);

	/**
	 * Returns one or more command-line options. Options are specified using
	 * standard CLI syntax:
	 *
	 *     php index.php --username=john.smith --password=secret --var="some value with spaces"
	 *
	 *     // Get the values of "username" and "password"
	 *     $auth = KoalaCLI::options('username', 'password');
	 *
	 * @param   string  $options,...    option name
	 * @return  array
	 */
	public static function options($options = NULL)
	{
		// Get all of the requested options
		$options = func_get_args();

		// Found option values
		$values = array();

		// Skip the first option, it is always the file executed
		for ($i = 1; $i < $_SERVER['argc']; $i++)
		{
			if ( ! isset($_SERVER['argv'][$i]))
			{
				// No more args left
				break;
			}

			// Get the option
			$opt = $_SERVER['argv'][$i];

			if (substr($opt, 0, 2) !== '--')
			{
				// This is a positional argument
				$values[] = $opt;
				continue;
			}

			// Remove the "--" prefix
			$opt = substr($opt, 2);

			if (strpos($opt, '='))
			{
				// Separate the name and value
				list ($opt, $value) = explode('=', $opt, 2);
			}
			else
			{
				$value = NULL;
			}

			$values[$opt] = $value;
		}

		if ($options)
		{
			foreach ($values as $opt => $value)
			{
				if ( ! in_array($opt, $options))
				{
					// Set the given value
					unset($values[$opt]);
				}
			}
		}

		return count($options) == 1 ? array_pop($values) : $values;
	}

	/**
	 * Reads input from the user. This can have either 1 or 2 arguments.
	 *
	 * Usage:
	 *
	 * // Waits for any key press
	 * KoalaCLI::read();
	 *
	 * // Takes any input
	 * $color = KoalaCLI::read('What is your favorite color?');
	 *
	 * // Will only accept the options in the array
	 * $ready = KoalaCLI::read('Are you ready?', array('y','n'));
	 *
	 * @param  string  $text    text to show user before waiting for input
	 * @param  array   $options array of options the user is shown
	 * @return string  the user input
	 */
	public static function read($text = '', array $options = NULL)
	{
		// If a question has been asked with the read
		$options_output = '';
		if ( ! empty($options))
		{
			$options_output = ' [ '.implode(', ', $options).' ]';
		}

		fwrite(STDOUT, $text.$options_output.': ');

		// Read the input from keyboard.
		$input = trim(fgets(STDIN));

		// If options are provided and the choice is not in the array, tell them to try again
		if ( ! empty($options) && ! in_array($input, $options))
		{
			KoalaCLI::write('This is not a valid option. Please try again.');

			$input = KoalaCLI::read($text, $options);
		}

		// Read the input
		return $input;
	}

	/**
	 * Experimental feature.
	 *
	 * Reads hidden input from the user
	 *
	 * Usage:
	 *
	 * $password = KoalaCLI::password('Enter your password');
	 *
	 * @author Mathew Davies.
	 * @return string
	 */
	public static function password($text = '')
	{
		$text .= ': ';

		if (Koala::$is_windows)
		{
			$vbscript = sys_get_temp_dir().'KoalaCLI_Password.vbs';

			// Create temporary file
			file_put_contents($vbscript, 'wscript.echo(InputBox("'.addslashes($text).'"))');

			$password = shell_exec('cscript //nologo '.escapeshellarg($command));

			// Remove temporary file.
			unlink($vbscript);
		}
		else
		{
			$password = shell_exec('/usr/bin/env bash -c \'read -s -p "'.escapeshellcmd($text).'" var && echo $var\'');
		}

		KoalaCLI::write();

		return trim($password);
	}

	/**
	 * Outputs a string to the cli. If you send an array it will implode them
	 * with a line break.
	 *
	 * @param string|array $text the text to output, or array of lines
	 */
	public static function write($text = '')
	{
		if (is_array($text))
		{
			foreach ($text as $line)
			{
				KoalaCLI::write($line);
			}
		}
		else
		{
			fwrite(STDOUT, $text.PHP_EOL);
		}
	}

	/**
	 * Outputs a replacable line to the cli. You can continue replacing the
	 * line until `TRUE` is passed as the second parameter in order to indicate
	 * you are done modifying the line.
	 *
	 *     // Sample progress indicator
	 *     KoalaCLI::write_replace('0%');
	 *     KoalaCLI::write_replace('25%');
	 *     KoalaCLI::write_replace('50%');
	 *     KoalaCLI::write_replace('75%');
	 *     // Done writing this line
	 *     KoalaCLI::write_replace('100%', TRUE);
	 *
	 * @param string  $text      the text to output
	 * @param boolean $end_line  whether the line is done being replaced
	 */
	public static function write_replace($text = '', $end_line = FALSE)
	{
		// Append a newline if $end_line is TRUE
		$text = $end_line ? $text.PHP_EOL : $text;
		fwrite(STDOUT, "\r\033[K".$text);
	}

	/**
	 * Waits a certain number of seconds, optionally showing a wait message and
	 * waiting for a key press.
	 *
	 * @author     Fuel Development Team
	 * @license    MIT License
	 * @copyright  2010 - 2011 Fuel Development Team
	 * @link       http://fuelphp.com
	 * @param int $seconds number of seconds
	 * @param bool $countdown show a countdown or not
	 */
	public static function wait($seconds = 0, $countdown = false)
	{
		if ($countdown === true)
		{
			$time = $seconds;

			while ($time > 0)
			{
				fwrite(STDOUT, $time.'... ');
				sleep(1);
				$time--;
			}

			KoalaCLI::write();
		}
		else
		{
			if ($seconds > 0)
			{
				sleep($seconds);
			}
			else
			{
				KoalaCLI::write(KoalaCLI::$wait_msg);
				KoalaCLI::read();
			}
		}
	}

	/**
	 * Returns the given text with the correct color codes for a foreground and
	 * optionally a background color.
	 *
	 * @author     Fuel Development Team
	 * @license    MIT License
	 * @copyright  2010 - 2011 Fuel Development Team
	 * @link       http://fuelphp.com
	 * @param string $text the text to color
	 * @param atring $foreground the foreground color
	 * @param string $background the background color
	 * @return string the color coded string
	 */
	public static function color($text, $foreground, $background = null)
	{

		if (Koala::$is_windows)
		{
			return $text;
		}

		if (!array_key_exists($foreground, KoalaCLI::$foreground_colors))
		{
			throw new Koala_Exception('Invalid CLI foreground color: '.$foreground);
		}

		if ($background !== null and !array_key_exists($background, KoalaCLI::$background_colors))
		{
			throw new Koala_Exception('Invalid CLI background color: '.$background);
		}

		$string = "\033[".KoalaCLI::$foreground_colors[$foreground]."m";

		if ($background !== null)
		{
			$string .= "\033[".KoalaCLI::$background_colors[$background]."m";
		}

		$string .= $text."\033[0m";

		return $string;
	}

}