#!/usr/env ruby
class MojGen
attr_reader :defines, :output
def initialize
	@defines = ""
	@output = ""
end
def stripComments (data)
	if(data =~ /^(\s)*define\((.*)\);/)
		@defines << data + "\n"
		return "" 
	end
	data.gsub!(/\/\*(.*)/,'')
	data.gsub!(/\s\*(.*)/,'')
	data.gsub!(/\/\/(.*)/,'')
	data.gsub!(/<\?(.*)/,'')
	data.gsub!(/\?>/,'')
	data.to_s
end

def readDir (name)
	Dir.foreach(name) { |file|
		if file =~ /^(\.)+/
			next	
		end
		if File.directory?(name + "/" + file)
			readDir(name + "/" + file)
		else
			f = File.new("#{name}/#{file}", "r")
			f.each_line { |data|
				stripped = stripComments(data)
				if !stripped.nil? and !stripped.strip.empty?
					@output << stripped.to_s
				end
			}
		end
	}
end
end
gen = MojGen.new
puts "<?php"
	gen.readDir("lib")
	puts gen.defines
	puts gen.output
puts "?>"
