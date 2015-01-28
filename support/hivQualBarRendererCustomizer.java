import net.sf.jasperreports.engine.JRChartCustomizer;
import net.sf.jasperreports.engine.JRChartDataset;
import net.sf.jasperreports.engine.JRChartPlot;
import net.sf.jasperreports.engine.JRChart;
import org.jfree.chart.JFreeChart;
import org.jfree.chart.axis.CategoryAxis;
import org.jfree.chart.plot.CategoryPlot;
import org.jfree.chart.renderer.category.BarRenderer;
import org.jfree.ui.RectangleInsets;

import java.awt.*;

public class hivQualBarRendererCustomizer implements JRChartCustomizer
{

  public void customize(JFreeChart chart, JRChart jasperChart)
    {
      // retrieve bar renderer
      BarRenderer renderer = (BarRenderer) chart.getCategoryPlot().getRenderer();

      // make space between bars zero width
      renderer.setItemMargin(0.0);

      // retrieve category axis
      CategoryAxis domAxis = (CategoryAxis) chart.getCategoryPlot().getDomainAxis();

      // extend max. width of labels
      domAxis.setMaximumCategoryLabelWidthRatio(2);

      // set padding on right to avoid truncation
      chart.setPadding(new RectangleInsets(0, 0, 0, 75));
    }
}

