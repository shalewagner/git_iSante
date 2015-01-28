import net.sf.jasperreports.engine.JRChartCustomizer;
import net.sf.jasperreports.engine.JRChartDataset;
import net.sf.jasperreports.engine.JRChartPlot;
import net.sf.jasperreports.engine.JRChart;
import org.jfree.chart.JFreeChart;
import org.jfree.chart.axis.DateAxis;
import org.jfree.chart.axis.DateTickMarkPosition;
import org.jfree.chart.axis.NumberAxis;
import org.jfree.chart.plot.XYPlot;
import org.jfree.data.Range;
import org.jfree.ui.RectangleInsets;

import java.awt.*;
import java.text.NumberFormat;
import java.util.Calendar;
import java.util.TimeZone;

public class TimeSeriesCustomizer implements JRChartCustomizer
{

  public void customize(JFreeChart chart, JRChart jasperChart)
    {
      // retrieve range (y) axis
      NumberAxis rangeAxis = (NumberAxis) chart.getXYPlot().getRangeAxis();

      // restrict y-axis to integer-valued labels only
      //rangeAxis.setStandardTickUnits (NumberAxis.createIntegerTickUnits());
      // above works fine, but is integer values only (as expected)

      // restrict y-axis to only 2 decimal places
      NumberFormat df = NumberFormat.getNumberInstance();
      df.setMaximumFractionDigits(2);
      rangeAxis.setNumberFormatOverride(df);
      // above works fine for only allowing 2 decimal places

      // if only one decimal value in the series, no y-axis label shows up
      //if (chart.getXYPlot().getDataset().getItemCount(0) == 1) {
      //  double val = chart.getXYPlot().getDataset().getYValue(0, 0);
      //  chart.getXYPlot().getDataset().setValue(0, val);
      //}
      // above not working, decided to do it via SQL instead

      // retrieve domain (x) axis
      DateAxis domAxis = (DateAxis) chart.getXYPlot().getDomainAxis();

      // make dates vertical so they don't get truncated at right edge
      //domAxis.setVerticalTickLabels(true);
      // above worked, but made graphs difficult to read

      // set the range for the domain axis (last 2 years)
      TimeZone tz = TimeZone.getTimeZone("America/Port-au-Prince");
      Calendar cal = Calendar.getInstance(tz);
      double startTime = cal.getTimeInMillis() - Long.parseLong("63115200000");
      double endTime = cal.getTimeInMillis();
      Range range = new Range(startTime, endTime);
      domAxis.setRange(range, true, true);
       
      // set padding on right to avoid truncation
      chart.setPadding(new RectangleInsets(0, 0, 0, 6));
      // above works perfectly for avoiding truncation at right edge
    }
}

