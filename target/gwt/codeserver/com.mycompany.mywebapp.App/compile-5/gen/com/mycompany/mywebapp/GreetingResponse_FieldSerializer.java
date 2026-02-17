package com.mycompany.mywebapp;

import com.google.gwt.user.client.rpc.SerializationException;
import com.google.gwt.user.client.rpc.SerializationStreamReader;
import com.google.gwt.user.client.rpc.SerializationStreamWriter;
import com.google.gwt.user.client.rpc.impl.ReflectionHelper;

@SuppressWarnings("deprecation")
public class GreetingResponse_FieldSerializer implements com.google.gwt.user.client.rpc.impl.TypeHandler {
  private static native java.lang.String getGreeting(com.mycompany.mywebapp.GreetingResponse instance) /*-{
    return instance.@com.mycompany.mywebapp.GreetingResponse::greeting;
  }-*/;
  
  private static native void setGreeting(com.mycompany.mywebapp.GreetingResponse instance, java.lang.String value) 
  /*-{
    instance.@com.mycompany.mywebapp.GreetingResponse::greeting = value;
  }-*/;
  
  private static native java.lang.String getServerInfo(com.mycompany.mywebapp.GreetingResponse instance) /*-{
    return instance.@com.mycompany.mywebapp.GreetingResponse::serverInfo;
  }-*/;
  
  private static native void setServerInfo(com.mycompany.mywebapp.GreetingResponse instance, java.lang.String value) 
  /*-{
    instance.@com.mycompany.mywebapp.GreetingResponse::serverInfo = value;
  }-*/;
  
  private static native java.lang.String getUserAgent(com.mycompany.mywebapp.GreetingResponse instance) /*-{
    return instance.@com.mycompany.mywebapp.GreetingResponse::userAgent;
  }-*/;
  
  private static native void setUserAgent(com.mycompany.mywebapp.GreetingResponse instance, java.lang.String value) 
  /*-{
    instance.@com.mycompany.mywebapp.GreetingResponse::userAgent = value;
  }-*/;
  
  public static void deserialize(SerializationStreamReader streamReader, com.mycompany.mywebapp.GreetingResponse instance) throws SerializationException {
    setGreeting(instance, streamReader.readString());
    setServerInfo(instance, streamReader.readString());
    setUserAgent(instance, streamReader.readString());
    
  }
  
  public static com.mycompany.mywebapp.GreetingResponse instantiate(SerializationStreamReader streamReader) throws SerializationException {
    return new com.mycompany.mywebapp.GreetingResponse();
  }
  
  public static void serialize(SerializationStreamWriter streamWriter, com.mycompany.mywebapp.GreetingResponse instance) throws SerializationException {
    streamWriter.writeString(getGreeting(instance));
    streamWriter.writeString(getServerInfo(instance));
    streamWriter.writeString(getUserAgent(instance));
    
  }
  
  public Object create(SerializationStreamReader reader) throws SerializationException {
    return com.mycompany.mywebapp.GreetingResponse_FieldSerializer.instantiate(reader);
  }
  
  public void deserial(SerializationStreamReader reader, Object object) throws SerializationException {
    com.mycompany.mywebapp.GreetingResponse_FieldSerializer.deserialize(reader, (com.mycompany.mywebapp.GreetingResponse)object);
  }
  
  public void serial(SerializationStreamWriter writer, Object object) throws SerializationException {
    com.mycompany.mywebapp.GreetingResponse_FieldSerializer.serialize(writer, (com.mycompany.mywebapp.GreetingResponse)object);
  }
  
}
