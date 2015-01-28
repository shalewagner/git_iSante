import java.util.UUID;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

class uuidGen {
  public static void main (String[] args) {
    if (args.length < 1) {
      args = new String[1];
      args[0] = "1";
    }

    Pattern isNumeric = Pattern.compile("([0-9]+)");
    Matcher m = isNumeric.matcher(args[0]);
    if (!m.matches()) {
      args[0] = "1";
    }

    int cnt = Integer.valueOf(args[0]).intValue();
    UUID uuid = null;
    while (cnt-- > 0) {
      uuid = UUID.randomUUID();
      System.out.println (uuid.toString());
    }
  }
}
