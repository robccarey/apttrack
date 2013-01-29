watch("Classes/(.*).php") do |match|
  run_test
end

watch("Tests/.*Test.php") do |match|
  run_test
end

def run_test
	#clear_console
	result = `phpunit Tests/`
	#puts result
	if result.match(/OK/)
		notify "aptTrack - tests PASSED", result, "dialog-info.png", 4000
	elsif result.match(/FAILURES\!/)
		notify_failed result
	end
end

def notify title, msg, img, show_time
  images_dir='/usr/share/icons/Mint-X/status/48'
  system "notify-send '#{title}' '#{msg}' -i #{images_dir}/#{img} -t #{show_time}"
end

def notify_failed result
  notify "aptTrack - test(s) FAILED", result, "dialog-error.png", 8000
end

def clear_console
  puts "\e[H\e[2J"  #clear console
end
