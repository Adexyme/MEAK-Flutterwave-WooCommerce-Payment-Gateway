const meak_flutterwave_settings = window.wc.wcSettings.getSetting(
  "meak_flutterwave_gateway_data",
  {}
);
const meak_flutterwave_label =
  window.wp.htmlEntities.decodeEntities(meak_flutterwave_settings.title) ||
  window.wp.i18n.__("Meak Flutterwave Gateway", "meak_flutterwave_gateway");
const Content = () => {
  return window.wp.htmlEntities.decodeEntities(
    meak_flutterwave_settings.description || ""
  );
};
const Meak_Flutterwave_Block_Gateway = {
  name: "meak_flutterwave_gateway",
  label: meak_flutterwave_label,
  content: Object(window.wp.element.createElement)(Content, null),
  edit: Object(window.wp.element.createElement)(Content, null),
  canMakePayment: () => true,
  ariaLabel: meak_flutterwave_label,
  supports: {
    features: meak_flutterwave_settings.supports,
  },
};
window.wc.wcBlocksRegistry.registerPaymentMethod(
  Meak_Flutterwave_Block_Gateway
);
