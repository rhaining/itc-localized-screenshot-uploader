. environment.sh

echo "Verifying..."

iTMSTransporter -m verify -u $ITMSUSER -p $ITMSPASS -vendor_id $ITMSSKU -f "$ITMSFOLDERNAME/$ITMSSKU.itmsp"
