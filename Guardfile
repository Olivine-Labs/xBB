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

guard 'process', :name => 'Minify CSS', :command => 'juicer merge app/css/*.css -o app/app.min.css --force' do
  watch(/^app\/css\/(.*)\.css/)
end

guard 'process', :name => 'Minify application javascript', :command => 'juicer merge app/js/libs/jquery-1.7.1.js app/js/libs/underscore/underscore.js app/js/libs/backbone/backbone.js app/js/libs/json2/json2.js app/js/libs/mustache/mustache.js app/js/libs/modernizr-2.0.6.js app/js/app/*/*.js -o app/app.min.js --force -i' do
  watch(/^app\/js\/(.*)\.js/)
end
