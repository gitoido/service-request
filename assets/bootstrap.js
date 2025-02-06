import { startStimulusApp } from '@symfony/stimulus-bundle';
import ServiceRequestController from "./controllers/service_request_controller.js";

const app = startStimulusApp();
// register any custom, 3rd party controllers here
app.register('service-request', ServiceRequestController);
