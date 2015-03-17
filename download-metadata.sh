. environment.sh

echo "Downloading..."

iTMSTransporter -m lookupMetadata -u $ITMSUSER -p $ITMSPASS -vendor_id $ITMSSKU -destination $ITMSFOLDERNAME

echo "itmsp package is now at $ITMSFOLDERNAME"
echo "Now put your screenshots into $ITMSSCREENSHOTSFOLDERNAME"
