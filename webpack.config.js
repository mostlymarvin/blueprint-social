module.exports = {
   context: __dirname,
   entry: './admin/blocks/src/blocks.js',
   mode: 'production',
   output: {
      path: __dirname + '/admin/blocks/dist/',
      filename: 'blocks.build.js'
   },
   watch:true,
   module: {
      rules: [
         {
            test: /.js$/,
            exclude: /node_modules/,
            use: [
               {
                  loader: 'babel-loader'
               }
         ],
         },
         {
            test: /\.scss$/,
            use: [
               {
                  loader: 'file-loader',
                  options: {
                        name: 'blocks.[name].build.css',
                  }
               },
               {
                  loader: 'extract-loader'
               },
               {
                  loader: 'css-loader',
               },
               {
                  loader: 'sass-loader',
                  options: {
                        sourceMap: true
                  }
               }
            ]
      },
      ],
   },
};
