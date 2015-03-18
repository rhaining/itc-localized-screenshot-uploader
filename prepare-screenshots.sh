. environment.sh

echo "Ensuring screenshots are flattened and in place in the package..."

for i in `find $ITMSSCREENSHOTSFOLDERRAWNAME -name \*.png -print`; do
	cp -v -f $i "$ITMSFOLDERNAME/$ITMSSKU.itmsp/"
done

echo "Now run php screenshots.php to splice in the new screenshots"
