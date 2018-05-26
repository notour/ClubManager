#!/bin/sh
DIR="$( cd "$( dirname "$0" )" && pwd )"
for fullfilepath in "$DIR"/*; do
    filename_with_extensions=$(basename "$fullfilepath")
    extension="${fullfilepath##*.}"
    filename="${filename_with_extensions%.*}"
    if [ "$extension" = "scss" ]
    then
        sass -f "$fullfilepath" "$DIR/../css/$filename.css"
    fi
done

# sass -f '$root_path/$file' '$output_path/$filename.css'