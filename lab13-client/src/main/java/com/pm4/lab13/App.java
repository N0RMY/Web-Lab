package com.pm4.lab13;

import com.google.gwt.core.client.EntryPoint;
import com.google.gwt.core.client.GWT;
import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.event.dom.client.ClickHandler;
import com.google.gwt.event.dom.client.KeyCodes;
import com.google.gwt.event.dom.client.KeyUpEvent;
import com.google.gwt.event.dom.client.KeyUpHandler;
import com.google.gwt.safehtml.shared.SafeHtmlBuilder;
import com.google.gwt.user.client.Window;
import com.google.gwt.user.client.rpc.AsyncCallback;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.DialogBox;
import com.google.gwt.user.client.ui.FormPanel;
import com.google.gwt.user.client.ui.HTML;
import com.google.gwt.user.client.ui.Label;
import com.google.gwt.user.client.ui.RootPanel;
import com.google.gwt.user.client.ui.TextBox;
import com.google.gwt.user.client.ui.VerticalPanel;
import com.google.gwt.user.client.ui.Frame;


public class App implements EntryPoint {

  private static final String SERVER_ERROR =
      "An error occurred while attempting to contact the server. Please check your network connection and try again.";

  private final GreetingServiceAsync greetingService = GWT.create(GreetingService.class);

  @Override
  public void onModuleLoad() {

    // ===== Header =====
    RootPanel header = RootPanel.get("header");
    if (header != null) {
      Label title = new Label("Lab13 - PM4");
      title.setStyleName("text-2xl font-bold text-center py-4");
      header.addStyleName("bg-gray-100 shadow");
      header.add(title);
    }

    // ===== Main RPC widgets =====
    final Button sendButton = new Button("Send to Server");
    sendButton.addStyleName("bg-green-500 px-4 py-2 rounded-lg text-white ml-4 hover:bg-green-600");

    final TextBox nameField = new TextBox();
    nameField.setText("GWT User");

    final Label errorLabel = new Label();

    // Контейнери повинні існувати в index.html (nameFieldContainer / sendButtonContainer / errorLabelContainer)
    RootPanel.get("nameFieldContainer").add(nameField);
    RootPanel.get("sendButtonContainer").add(sendButton);
    RootPanel.get("errorLabelContainer").add(errorLabel);

    nameField.setFocus(true);
    nameField.selectAll();

    // ===== DialogBox =====
    final DialogBox dialogBox = new DialogBox();
    dialogBox.setText("Remote Procedure Call");
    dialogBox.setAnimationEnabled(true);
    dialogBox.addStyleName("bg-green-500 px-4 py-3 rounded-lg text-white");

    final Button closeButton = new Button("Close");
    closeButton.getElement().setId("closeButton");

    final Label textToServerLabel = new Label();
    final HTML serverResponseLabel = new HTML();

    VerticalPanel dialogVPanel = new VerticalPanel();
    dialogVPanel.addStyleName("dialogVPanel");
    dialogVPanel.add(new HTML("<b>Sending name to the server:</b>"));
    dialogVPanel.add(textToServerLabel);
    dialogVPanel.add(new HTML("<br><b>Server replies:</b>"));
    dialogVPanel.add(serverResponseLabel);
    dialogVPanel.setHorizontalAlignment(VerticalPanel.ALIGN_RIGHT);
    dialogVPanel.add(closeButton);

    dialogBox.setWidget(dialogVPanel);

    closeButton.addClickHandler(new ClickHandler() {
      @Override
      public void onClick(ClickEvent event) {
        dialogBox.hide();
        sendButton.setEnabled(true);
        sendButton.setFocus(true);
      }
    });

    // ===== Subscribe block (FormPanel) =====
    FormPanel form = new FormPanel();
    form.setMethod(FormPanel.METHOD_POST);
    form.setAction("#"); // формально, але реально не відправляємо

    VerticalPanel layout = new VerticalPanel();
    layout.addStyleName("p-4 bg-white rounded-lg shadow mt-6 w-full max-w-md mx-auto");

    Label formTitle = new Label("Підписка");
    formTitle.setStyleName("text-xl font-semibold mb-3 text-center");

    final TextBox nameBox = new TextBox();
    nameBox.getElement().setPropertyString("placeholder", "Ваше ім'я");
    nameBox.setName("name");
    nameBox.addStyleName("border rounded px-3 py-2 w-full mb-3");

    final TextBox emailBox = new TextBox();
    emailBox.getElement().setPropertyString("placeholder", "Email");
    emailBox.setName("email");
    emailBox.addStyleName("border rounded px-3 py-2 w-full mb-3");

    Button subscribeBtn = new Button("Підписатися");
    subscribeBtn.addStyleName("bg-blue-500 px-4 py-2 rounded-lg text-white w-full hover:bg-blue-600");

    layout.add(formTitle);
    layout.add(nameBox);
    layout.add(emailBox);
    layout.add(subscribeBtn);

    form.setWidget(layout);
    RootPanel.get().add(form);

    subscribeBtn.addClickHandler(new ClickHandler() {
      @Override
      public void onClick(ClickEvent event) {
        String name = nameBox.getText().trim();
        String email = emailBox.getText().trim();

        if (name.isEmpty() || email.isEmpty()) {
          Window.alert("Заповніть ім'я та email!");
          return;
        }
        Window.alert("Дякуємо за підписку!\nІм'я: " + name + "\nEmail: " + email);
      }
    });

    // ===== RPC handler =====
    class MyHandler implements ClickHandler, KeyUpHandler {
      @Override
      public void onClick(ClickEvent event) {
        sendNameToServer();
      }

      @Override
      public void onKeyUp(KeyUpEvent event) {
        if (event.getNativeKeyCode() == KeyCodes.KEY_ENTER) {
          sendNameToServer();
        }
      }

      private void sendNameToServer() {
        errorLabel.setText("");
        String textToServer = nameField.getText();

        if (!FieldVerifier.isValidName(textToServer)) {
          errorLabel.setText("Please enter at least four characters");
          return;
        }

        sendButton.setEnabled(false);
        textToServerLabel.setText(textToServer);
        serverResponseLabel.setText("");

        greetingService.greetServer(textToServer, new AsyncCallback<GreetingResponse>() {
          @Override
          public void onFailure(Throwable caught) {
            dialogBox.setText("Remote Procedure Call - Failure");
            serverResponseLabel.addStyleName("serverResponseLabelError");
            serverResponseLabel.setHTML(SERVER_ERROR);
            dialogBox.center();
            closeButton.setFocus(true);
          }

          @Override
          public void onSuccess(GreetingResponse result) {
            dialogBox.setText("Remote Procedure Call");
            serverResponseLabel.removeStyleName("serverResponseLabelError");
            serverResponseLabel.setHTML(new SafeHtmlBuilder()
                .appendEscaped(result.getGreeting())
                .appendHtmlConstant("<br><br>I am running ")
                .appendEscaped(result.getServerInfo())
                .appendHtmlConstant(".<br><br>It looks like you are using:<br>")
                .appendEscaped(result.getUserAgent())
                .toSafeHtml());
            dialogBox.center();
            closeButton.setFocus(true);
          }
        });
      }
    }


	// ===== Weather widget (Frame) =====
	RootPanel weatherButtonPanel = RootPanel.get("weatherButton");
	RootPanel weatherContainerPanel = RootPanel.get("weatherContainer");

	if (weatherButtonPanel != null && weatherContainerPanel != null) {

	Button weatherBtn = new Button("Показати погоду");
	weatherBtn.addStyleName("bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg mt-6");

	weatherBtn.addClickHandler(new ClickHandler() {
		@Override
		public void onClick(ClickEvent event) {
		weatherContainerPanel.clear();

		// Тут має бути ТІЛЬКИ src (URL) з Meteoblue
		String weatherSrc =
			"https://www.meteoblue.com/en/weather/widget/daily/rivne_ukraine_695594"
			+ "?geoloc=fixed&tempunit=CELSIUS&windunit=KILOMETER_PER_HOUR&precipunit=MILLIMETER"
			+ "&days=7&coloured=coloured&pictoicon=1&maxtemperature=1&mintemperature=1"
			+ "&windspeed=1&winddirection=1&precipitation=1&precipitationprobability=1"
			+ "&spot=1&layout=light&user_key=cda6726a9c548908&embed_key=31fd4e7bef7b21db"
			+ "&sig=0d628fde6730feba308fccf3eb08d8011a511bb4770c3303a618633fe2fdfc45";

		Frame frame = new Frame(weatherSrc);
		frame.getElement().setAttribute("scrolling", "yes");
		frame.getElement().setAttribute("frameborder", "0");

		frame.setWidth("100%");
		frame.setHeight("500px");

		weatherContainerPanel.add(frame);
		}
	});

	weatherButtonPanel.add(weatherBtn);
	}

  }
}
