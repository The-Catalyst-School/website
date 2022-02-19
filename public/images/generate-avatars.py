import svgutils.transform as sg



for i in range(1,15):
    for j in range(1,11):
        print(i, j)
        fig = sg.SVGFigure(151, 151)
        fig0 = sg.fromfile(f"base.svg")
        fig1 = sg.fromfile(f"eyes-{i}.svg")
        fig2 = sg.fromfile(f"mouth-{j}.svg")

        plot0 = fig0.getroot()
        plot1 = fig1.getroot()
        plot2 = fig2.getroot()

        fig.append([plot0, plot1, plot2])
        fig.set_size(("151px", "151px"))

        fig.save(f"avatars/{i}-{j}.svg")
