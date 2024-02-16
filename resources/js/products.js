import React from "react";
import { DivWrapper } from "./DivWrapper";
import "..css/productsStyles.css";

export const ContentCanvas = () => {
  return (
    <div className="content-canvas">
      <div className="div">
        <div className="product">
          <div className="overlap">
            <img className="img" alt="Sdn" src="sdn28-1.png" />
            <div className="rectangle" />
            <div className="add-quantity">
              <DivWrapper className="component-50" />
              <div className="overlap-group">
                <DivWrapper className="component-50-instance" text="+" />
                <div className="text-wrapper">1</div>
              </div>
            </div>
            <div className="pricetag">
              <div className="ellipse-wrapper">
                <div className="ellipse" />
              </div>
            </div>
            <div className="text-wrapper-2">Price ₱ 300.00</div>
            <div className="text-wrapper-3">Superdog Nutrition Premium</div>
          </div>
        </div>
        <div className="overlap-wrapper">
          <div className="overlap">
            <img className="img" alt="Sdn og" src="SDN-og-1.png" />
            <div className="rectangle" />
            <div className="add-quantity-2">
              <DivWrapper className="design-component-instance-node" text="-" />
              <div className="overlap-group-2">
                <DivWrapper className="component-50-instance" text="+" />
                <div className="text-wrapper-4">1</div>
              </div>
            </div>
            <div className="pricetag">
              <div className="overlap-2">
                <div className="ellipse" />
              </div>
            </div>
            <div className="text-wrapper-5">Price ₱ 300.00</div>
            <div className="text-wrapper-3">Superdog Nutrition Original</div>
          </div>
        </div>
        <img className="product-2" alt="Product" src="product-1.png" />
      </div>
    </div>
  );
};
