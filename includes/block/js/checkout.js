const settings = window.wc.wcSettings.getSetting(
  "meak_flutterwave_gateway_data",
  {}
);
const label =
  window.wp.htmlEntities.decodeEntities(settings.title) ||
  window.wp.i18n.__("Meak Flutterwave Gateway", "meak_flutterwave_gateway");
const Content = () => {
  return window.wp.htmlEntities.decodeEntities(settings.description || "");
};
const Block_Gateway = {
  name: "meak_flutterwave_gateway",
  label: label,
  content: Object(window.wp.element.createElement)(Content, null),
  edit: Object(window.wp.element.createElement)(Content, null),
  canMakePayment: () => true,
  ariaLabel: label,
  supports: {
    features: settings.supports,
  },
};
window.wc.wcBlocksRegistry.registerPaymentMethod(Block_Gateway);
