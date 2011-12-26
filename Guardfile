guard 'coffeescript', :output => 'app/js/app' do
  watch(/^app\/src\/coffeescript\/(.*)\.coffee/)
end

guard 'coffeescript', :output => 'spec/javascripts' do
  watch(/^spec\/coffeescripts\/(.*)\.coffee/)
end

guard 'livereload', :apply_js_live => false do
  watch(/^spec\/javascripts\/.+\.js$/)
  watch(/^app\/js\/app\/compiled\/.+\.js$/)
end

guard 'sass', :input => 'app/src/sass', :output => 'app/css', :style => :compressed, :shallow => true, :all_on_start => true 
